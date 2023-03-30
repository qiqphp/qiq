<?php
declare(strict_types=1);

namespace Qiq\Compiler;

use Qiq\Compiler;

class NonCompiler implements Compiler
{
    public function compile(string $source) : string
    {
        return $source;
    }

    public function clear() : void
    {
        // no-op
    }
}
