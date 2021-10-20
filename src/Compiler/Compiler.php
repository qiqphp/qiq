<?php
namespace Qiq\Compiler;

interface Compiler
{
    public function __invoke(string $source) : string;

    public function clear() : void;
}
