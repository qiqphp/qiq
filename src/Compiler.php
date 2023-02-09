<?php
declare(strict_types=1);

namespace Qiq;

interface Compiler
{
    public function __invoke(string $source) : string;

    public function clear() : void;
}
