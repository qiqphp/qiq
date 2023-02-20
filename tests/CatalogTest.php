<?php
declare(strict_types=1);

namespace Qiq;

use Qiq\Compiler\QiqCompiler;

class CatalogTest extends \PHPUnit\Framework\TestCase
{
    protected string $cachePath;

    protected QiqCompiler $compiler;

    protected Catalog $catalog;

    protected function setUp() : void
    {
        $this->cachePath = __DIR__ . DIRECTORY_SEPARATOR . 'cache';
        $this->compiler = new QiqCompiler($this->cachePath);
        $this->compiler->clear();

        $this->catalog = $this->newCatalog();
    }

    /**
     * @param string[] $paths
     */
    protected function newCatalog(array $paths = []) : Catalog
    {
        return new Catalog($paths, '.php');
    }

    public function testHasGet() : void
    {
        $this->catalog->setPaths([__DIR__ . '/templates']);

        $this->assertTrue($this->catalog->has('index'));
        $actual = $this->catalog->getCompiled($this->compiler, 'index');

        $target = str_replace('/', DIRECTORY_SEPARATOR, __DIR__ . '/templates/index.php');

        if (PHP_OS_FAMILY === 'Windows') {
            $target= substr($target, 2);
        }

        $expect = $this->cachePath . $target;
        $this->assertSame($expect, $actual);

        $this->assertFalse($this->catalog->has('no-such-template'));
        $this->expectException(Exception\FileNotFound::CLASS);
        $this->catalog->getCompiled($this->compiler, 'no-such-template');
    }

    public function testDoubleDots() : void
    {
        $this->expectException(Exception\FileNotFound::CLASS);
        $this->expectExceptionMessage("Double-dots not allowed in template specifications");
        $this->catalog->getCompiled($this->compiler, 'foo/../bar');
    }

    public function testSetAndGetPaths() : void
    {
        // should be no paths yet
        $expect = [];
        $actual = $this->catalog->getPaths();
        $this->assertSame($expect, $actual);

        // set the paths
        $expect = ['__DEFAULT__' => [
            DIRECTORY_SEPARATOR . 'foo',
            DIRECTORY_SEPARATOR . 'bar',
            DIRECTORY_SEPARATOR . 'baz',
        ]];
        $this->catalog->setPaths(['/foo', '/bar', '/baz']);
        $actual = $this->catalog->getPaths();
        $this->assertSame($expect, $actual);
    }

    public function testPrependPath() : void
    {
        $this->catalog->prependPath('/foo');
        $this->catalog->prependPath('/bar');
        $this->catalog->prependPath('/baz');

        $expect = ['__DEFAULT__' => [
            DIRECTORY_SEPARATOR . 'baz',
            DIRECTORY_SEPARATOR . 'bar',
            DIRECTORY_SEPARATOR . 'foo',
        ]];
        $actual = $this->catalog->getPaths();
        $this->assertSame($expect, $actual);
    }

    public function testAppendPath() : void
    {
        $this->catalog->appendPath('/foo');
        $this->catalog->appendPath('/bar');
        $this->catalog->appendPath('/baz');

        $expect = ['__DEFAULT__' => [
            DIRECTORY_SEPARATOR . 'foo',
            DIRECTORY_SEPARATOR . 'bar',
            DIRECTORY_SEPARATOR . 'baz',
        ]];
        $actual = $this->catalog->getPaths();
        $this->assertSame($expect, $actual);
    }

    public function testFindFallbacks() : void
    {
        $dir = __DIR__ . DIRECTORY_SEPARATOR
            . 'templates' . DIRECTORY_SEPARATOR;

        $catalog = $this->newCatalog([
            $dir . 'foo',
        ]);

        $this->assertOutput('foo', $catalog->getCompiled($this->compiler, 'test'));

        $catalog = $this->newCatalog([
            $dir . 'bar',
            $dir . 'foo',
        ]);
        $this->assertOutput('bar', $catalog->getCompiled($this->compiler, 'test'));

        $catalog = $this->newCatalog([
            $dir . 'baz',
            $dir . 'bar',
            $dir . 'foo',
        ]);
        $this->assertOutput('baz', $catalog->getCompiled($this->compiler, 'test'));

        // get it again for code coverage
        $this->assertOutput('baz', $catalog->getCompiled($this->compiler, 'test'));

        // look for a file that doesn't exist
        $catalog->setExtension('.phtml');
        $this->expectException(Exception\FileNotFound::CLASS);
        $catalog->getCompiled($this->compiler, 'test');
    }

    public function testCollections() : void
    {
        $dir = __DIR__ . '/templates';

        $this->catalog->setPaths([
            "foo:{$dir}/foo",
            "bar:{$dir}/bar",
            "baz:{$dir}/baz",
        ]);

        $this->assertOutput('foo', $this->catalog->getCompiled($this->compiler, 'foo:test'));
        $this->assertOutput('bar', $this->catalog->getCompiled($this->compiler, 'bar:test'));
        $this->assertOutput('baz', $this->catalog->getCompiled($this->compiler, 'baz:test'));
    }

    public function testRecompile() : void
    {
        $this->catalog->setPaths([__DIR__ . '/templates']);
        $actual = $this->catalog->recompile($this->compiler);

        foreach ($actual as $file) {
            $this->assertTrue(str_starts_with($file, $this->cachePath));
        }

        // the count will change as number of templates changes
        $this->assertCount(21, $actual);
    }

    protected function assertOutput(string $expect, string $file) : void
    {
        ob_start();
        require $file;
        $actual = ob_get_clean();
        $this->assertSame($expect, $actual);
    }
}
