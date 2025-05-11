<?php

declare(strict_types=1);

namespace Horde\Composer;

use Stringable;

interface VendorPackage
{
    public function hasFile(string|Stringable $relativePath): bool;
}
