<?php
namespace Qiq\Compiler;

class QiqCompilerTest extends \PHPUnit\Framework\TestCase
{
    protected QiqCompiler $compiler;

    protected string $cacheDir = '';

    protected function setUp() : void
    {
        $this->sourceDir = $this->osdir(dirname(__DIR__) . '/templates');
        $this->cachePath = $this->osdir(dirname(__DIR__) . '/cache');
        $this->compiler = new QiqCompiler($this->cachePath);
        $this->compiler->clear();
    }

    protected function osdir(string $path)
    {
        $path = str_replace('/', DIRECTORY_SEPARATOR, $path);
        return str_replace(
            DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR,
            DIRECTORY_SEPARATOR,
            $path
        );
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
        return $this->sourceDir . DIRECTORY_SEPARATOR . $name . '.php';
    }

    protected function cachedFile(string $name)
    {
        return $this->osdir("{$this->cachePath}/{$this->sourceDir}/{$name}.php");
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
            $this->osdir($this->sourceDir . '/index.php'),
            $this->osdir($this->sourceDir . '/mtime.php')
        );

        $expect = $this->cachedFile('mtime');
        $this->assertNotReadable($expect);
        $actual = $this->compile('mtime');
        $this->assertSame($expect, $actual);
        $this->assertReadable($expect);

        sleep(1);
        touch($this->osdir($this->sourceDir . '/mtime.php'));
        $actual = $this->compile('mtime');
        $this->assertSame($expect, $actual);
        $this->assertReadable($expect);

        unlink($this->osdir($this->sourceDir . '/mtime.php'));
    }
}
