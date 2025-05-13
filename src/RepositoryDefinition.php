<?php
namespace Horde\Composer;

use stdClass;

interface RepositoryDefinition
{
    public function getType(): string;

    public function dumpStdClass();
}