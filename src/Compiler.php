<?php
declare(strict_types=1);

namespace Qiq;

interface Compiler
{
    public function compile(string $source) : string;

    public function clear() : void;
}
