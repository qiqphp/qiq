<?php
declare(strict_types=1);

namespace Qiq\Compiler;

use Qiq\Compiler;

class FakeCompiler implements Compiler
{
    public function __invoke(string $source) : string
    {
        return $source;
    }

    public function clear() : void
    {
    }
}
