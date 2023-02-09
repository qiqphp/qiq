<?php
declare(strict_types=1);

namespace Qiq\Compiler;

class QiqCompilerTest extends \PHPUnit\Framework\TestCase
{
    protected QiqCompiler $compiler;

    protected string $cacheDir = '';

    protected function setUp() : void
    {
        $this->sourceDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'templates';
        $this->cachePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'cache';
        $this->compiler = new QiqCompiler($this->cachePath);
        $this->compiler->clear();
    }

    protected function compile(string $name)
    {
        return ($this->compiler)($this->sourceFile($name));
    }

    protected function assertReadable(string $file)
    {
        $this->assertTrue(is_readable($file));
    }

    protected function assertNotReadable(string $file)
    {
        $this->assertFalse(is_readable($file));
    }

    protected function sourceFile(string $name)
    {
        return $this->sourceDir . DIRECTORY_SEPARATOR
            . str_replace('/', DIRECTORY_SEPARATOR, $name)
            . '.php';
    }

    protected function cachedFile(string $name)
    {
        $file = $this->cachePath;

        $file .= (PHP_OS_FAMILY === 'Windows')
            ? substr($this->sourceDir, 2)
            : $this->sourceDir;

        return $file . DIRECTORY_SEPARATOR
            . str_replace('/', DIRECTORY_SEPARATOR, $name)
            . '.php';
    }

    public function test()
    {
        // no target dir, no target file
        $expect = $this->cachedFile('index');
        $this->assertNotReadable($expect);
        $actual = $this->compile('index');
        $this->assertSame($expect, $actual);
        $this->assertReadable($expect);

        // target dir, but no target file
        $expect = $this->cachedFile('master');
        $this->assertNotReadable($expect);
        $actual = $this->compile('master');
        $this->assertSame($expect, $actual);
        $this->assertReadable($expect);
    }

    public function testFilemtime()
    {
        copy(
            $this->sourceDir . '/index.php',
            $this->sourceDir . '/mtime.php'
        );

        $expect = $this->cachedFile('mtime');
        $this->assertNotReadable($expect);
        $actual = $this->compile('mtime');
        $this->assertSame($expect, $actual);
        $this->assertReadable($expect);

        sleep(1);
        touch($this->sourceDir . '/mtime.php');
        $actual = $this->compile('mtime');
        $this->assertSame($expect, $actual);
        $this->assertReadable($expect);

        unlink($this->sourceDir . '/mtime.php');
    }

    public function testClear_noSuchDirectory()
    {
        $dir = dirname(__DIR__) . '/nonesuch';
        $compiler = new QiqCompiler($dir);
        $compiler->clear();
        $this->assertFalse(is_dir($dir));
    }
}
