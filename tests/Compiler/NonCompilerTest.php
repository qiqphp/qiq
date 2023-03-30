<?php
declare(strict_types=1);

namespace Qiq\Compiler;

class NonCompilerTest extends \PHPUnit\Framework\TestCase
{
    public function test() : void
    {
        $compiler = new NonCompiler();
        $compiler->clear();
        $expect = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'templates/index.php';
        $actual = $compiler->compile($expect);
        $this->assertSame($expect, $actual);
    }
}
