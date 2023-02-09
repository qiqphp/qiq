<?php
declare(strict_types=1);

namespace Qiq\Compiler;

interface Compiler
{
    public function __invoke(string $source) : string;

    public function clear() : void;
}
