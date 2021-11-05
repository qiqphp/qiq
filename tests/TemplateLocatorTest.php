<?php
namespace Qiq;

class TemplateLocatorTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp() : void
    {
        $this->templateLocator = $this->newTemplateLocator();
        $this->templateLocator->clear();
    }

    protected function newTemplateLocator(array $paths = [])
    {
        return new TemplateLocator($paths, '.php', new Compiler\FakeCompiler());
    }

    protected function osdir(string $path)
    {
        return str_replace('/', DIRECTORY_SEPARATOR, $path);
    }

    public function testHasGet()
    {
        $this->templateLocator->setPaths([
            $this->osdir(__DIR__ . '/templates')
        ]);

        $this->assertTrue($this->templateLocator->has('index'));
        $actual = $this->templateLocator->get('index');
        $this->assertSame(
            $this->osdir(__DIR__ . '/templates/index.php'),
            $actual
        );

        $this->assertFalse($this->templateLocator->has('no-such-template'));
        $this->expectException(Exception\TemplateNotFound::CLASS);
        $this->templateLocator->get('no-such-template');
    }

    public function testSetAndGetPaths()
    {
        // should be no paths yet
        $expect = [];
        $actual = $this->templateLocator->getPaths();
        $this->assertSame($expect, $actual);

        // set the paths
        $paths = [
            $this->osdir('/foo'),
            $this->osdir('/bar'),
            $this->osdir('/baz'),
        ];

        $expect = ['__DEFAULT__' => $paths];

        $this->templateLocator->setPaths($paths);
        $actual = $this->templateLocator->getPaths();
        $this->assertSame($expect, $actual);
    }

    public function testPrependPath()
    {
        $this->templateLocator->prependPath($this->osdir('/foo'));
        $this->templateLocator->prependPath($this->osdir('/bar'));
        $this->templateLocator->prependPath($this->osdir('/baz'));

        $paths = [
            $this->osdir('/baz'),
            $this->osdir('/bar'),
            $this->osdir('/foo'),
        ];

        $expect = ['__DEFAULT__' => $paths];
        $actual = $this->templateLocator->getPaths();
        $this->assertSame($expect, $actual);
    }

    public function testAppendPath()
    {
        $this->templateLocator->appendPath($this->osdir('/foo'));
        $this->templateLocator->appendPath($this->osdir('/bar'));
        $this->templateLocator->appendPath($this->osdir('/baz'));

        $paths = [
            $this->osdir('/foo'),
            $this->osdir('/bar'),
            $this->osdir('/baz'),
        ];

        $expect = ['__DEFAULT__' => $paths];
        $actual = $this->templateLocator->getPaths();
        $this->assertSame($expect, $actual);
    }

    public function testFindFallbacks()
    {
        $dir = $this->osdir(__DIR__ . '/templates/');

        $templateLocator = $this->newTemplateLocator([
            $dir . 'foo',
        ]);
        $this->assertOutput('foo', $templateLocator->get('test'));

        $templateLocator = $this->newTemplateLocator([
            $dir . 'bar',
            $dir . 'foo',
        ]);
        $this->assertOutput('bar', $templateLocator->get('test'));

        $templateLocator = $this->newTemplateLocator([
            $dir . 'baz',
            $dir . 'bar',
            $dir . 'foo',
        ]);
        $this->assertOutput('baz', $templateLocator->get('test'));

        // get it again for code coverage
        $this->assertOutput('baz', $templateLocator->get('test'));

        // look for a file that doesn't exist
        $templateLocator->setExtension('.phtml');
        $this->expectException(Exception\TemplateNotFound::CLASS);
        $templateLocator->get('test');
    }

    public function testCollections()
    {
        $dir = __DIR__ . '/templates';

        $this->templateLocator->setPaths([
            $this->osdir("foo:$dir/foo"),
            $this->osdir("bar:$dir/bar"),
            $this->osdir("baz:$dir/baz"),
        ]);

        $this->assertOutput('foo', $this->templateLocator->get('foo:test'));
        $this->assertOutput('bar', $this->templateLocator->get('bar:test'));
        $this->assertOutput('baz', $this->templateLocator->get('baz:test'));
    }

    protected function assertOutput(string $expect, string $file) : void
    {
        ob_start();
        require $file;
        $actual = ob_get_clean();
        $this->assertSame($expect, $actual);
    }
}
