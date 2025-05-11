<?php

declare(strict_types=1);

namespace Horde\PhpConfigFile\Test\Unit;

use Horde\PhpConfigFile\PhpConfigFile;
use PHPUnit\Framework\TestCase;
use Stringable;
use PhpUnit\Framework\Attributes\CoversClass;
use Horde\Composer\ComposerJsonFile;
use Horde\Composer\InvalidComposerJsonFileException;

#[CoversNothing]
class ComposerJsonFileTest extends TestCase
{
    public function testReadEmptyConfigFileThrowsException(): void
    {
        $this->expectException(InvalidComposerJsonFileException::class);
        $uut = new ComposerJsonFile(dirname(__DIR__, 1) . '/fixtures/empty/composer.json');
    }
}