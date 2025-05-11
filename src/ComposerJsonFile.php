<?php

declare(strict_types=1);

namespace Horde\Composer;

use InvalidArgumentException;
use RuntimeException;
use stdClass;
use Stringable;
use JsonException;

class ComposerJsonFile implements Stringable
{
    private stdClass $composerJson;
    public function __construct(
        private string $filePath
    ) {
        if (!file_exists($this->filePath)) {
            throw new InvalidComposerJsonFileException("File does not exist: {$this->filePath}");
        }
        if (!is_readable($this->filePath)) {
            throw new InvalidComposerJsonFileException("File is not readable: {$this->filePath}");
        }
        $content = file_get_contents($this->filePath);
        if (!json_validate($content)) {
            throw new InvalidComposerJsonFileException("Invalid JSON in file: {$this->filePath}");
        }
        $this->composerJson = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
    }

    public function __toString(): string
    {
        $json = json_encode($this->composerJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        if ($json === false) {
            throw new JsonException("Failed to encode JSON: " . json_last_error_msg());
        }
        return $json;
    }

    public function save(): void
    {
        if (file_put_contents($this->filePath, $this) === false) {
            throw new RuntimeException("Failed to write to file: {$this->filePath}");
        }
    }

    public function getName(bool $failIfMissing = false): string
    {
        if ($failIfMissing && !isset($this->composerJson->name)) {
            throw new RuntimeException("Package name not found in composer.json");
        }
        return $this->composerJson->name ?? '';
    }

    public function setName(string|Stringable $name): self
    {
        if (mb_strpos((string) $name, '/') === false) {
            throw new InvalidArgumentException("Invalid name: {$name}");
        }
        $this->composerJson->name = (string) $name;
        return $this;
    }

}
