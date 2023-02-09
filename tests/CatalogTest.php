<?php
declare(strict_types=1);

namespace Qiq;

class CatalogTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp() : void
    {
        $this->catalog = $this->newCatalog();
        $this->catalog->clear();
    }

    protected function newCatalog(array $paths = [])
    {
        return new Catalog($paths, '.php', new Compiler\FakeCompiler());
    }

    public function testHasGet()
    {
        $this->catalog->setPaths([__DIR__ . '/templates']);

        $this->assertTrue($this->catalog->has('index'));
        $actual = $this->catalog->get('index');

        $expect = str_replace('/', DIRECTORY_SEPARATOR, __DIR__ . '/templates/index.php');
        $this->assertSame($expect, $actual);

        $this->assertFalse($this->catalog->has('no-such-template'));
        $this->expectException(Exception\TemplateNotFound::CLASS);
        $this->catalog->get('no-such-template');
    }

    public function testDoubleDots()
    {
        $this->expectException(Exception\TemplateNotFound::CLASS);
        $this->expectExceptionMessage("Double-dots not allowed in template specifications");
        $this->catalog->get('foo/../bar');
    }

    public function testSetAndGetPaths()
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

    public function testPrependPath()
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

    public function testAppendPath()
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

    public function testFindFallbacks()
    {
        $dir = __DIR__ . DIRECTORY_SEPARATOR
            . 'templates' . DIRECTORY_SEPARATOR;

        $catalog = $this->newCatalog([
            $dir . 'foo',
        ]);

        $this->assertOutput('foo', $catalog->get('test'));

        $catalog = $this->newCatalog([
            $dir . 'bar',
            $dir . 'foo',
        ]);
        $this->assertOutput('bar', $catalog->get('test'));

        $catalog = $this->newCatalog([
            $dir . 'baz',
            $dir . 'bar',
            $dir . 'foo',
        ]);
        $this->assertOutput('baz', $catalog->get('test'));

        // get it again for code coverage
        $this->assertOutput('baz', $catalog->get('test'));

        // look for a file that doesn't exist
        $catalog->setExtension('.phtml');
        $this->expectException(Exception\TemplateNotFound::CLASS);
        $catalog->get('test');
    }

    public function testCollections()
    {
        $dir = __DIR__ . '/templates';

        $this->catalog->setPaths([
            "foo:{$dir}/foo",
            "bar:{$dir}/bar",
            "baz:{$dir}/baz",
        ]);

        $this->assertOutput('foo', $this->catalog->get('foo:test'));
        $this->assertOutput('bar', $this->catalog->get('bar:test'));
        $this->assertOutput('baz', $this->catalog->get('baz:test'));
    }

    protected function assertOutput(string $expect, string $file) : void
    {
        ob_start();
        require $file;
        $actual = ob_get_clean();
        $this->assertSame($expect, $actual);
    }
}
