<?php
declare(strict_types=1);
namespace Horde\Composer;

use stdClass;
use Stringable;

class DefaultRepositoryDefinition implements RepositoryDefinition
{
    public readonly string $url;

    public function __construct(public readonly string $type = 'vcs', string|Stringable $url, public readonly stdClass $repositoryOptions = new stdClass)
    {
        // Cast to string once rather than everywhere.
        $this->url = (string) $url;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function dumpStdClass()
    {
        return (object) [
            'type' => 'path',
            'options' => $this->repositoryOptions,
            'url' => $this->url
        ];
    }
}