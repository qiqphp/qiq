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

    public function testHasGet()
    {
        $this->templateLocator->setPaths([__DIR__ . '/templates']);

        $this->assertTrue($this->templateLocator->has('index'));
        $actual = $this->templateLocator->get('index');
        $this->assertSame(Fsio::osdirsep(__DIR__ . '/templates/index.php'), $actual);

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
        $expect = ['__DEFAULT__' => [
            Fsio::osdirsep('/foo'),
            Fsio::osdirsep('/bar'),
            Fsio::osdirsep('/baz'),
        ]];
        $this->templateLocator->setPaths(['/foo', '/bar', '/baz']);
        $actual = $this->templateLocator->getPaths();
        $this->assertSame($expect, $actual);
    }

    public function testPrependPath()
    {
        $this->templateLocator->prependPath('/foo');
        $this->templateLocator->prependPath('/bar');
        $this->templateLocator->prependPath('/baz');

        $expect = ['__DEFAULT__' => [
            Fsio::osdirsep('/baz'),
            Fsio::osdirsep('/bar'),
            Fsio::osdirsep('/foo'),
        ]];
        $actual = $this->templateLocator->getPaths();
        $this->assertSame($expect, $actual);
    }

    public function testAppendPath()
    {
        $this->templateLocator->appendPath('/foo');
        $this->templateLocator->appendPath('/bar');
        $this->templateLocator->appendPath('/baz');

        $expect = ['__DEFAULT__' => [
            Fsio::osdirsep('/foo'),
            Fsio::osdirsep('/bar'),
            Fsio::osdirsep('/baz'),
        ]];
        $actual = $this->templateLocator->getPaths();
        $this->assertSame($expect, $actual);
    }

    public function testFindFallbacks()
    {
        $dir = Fsio::osdirsep(__DIR__ . '/templates/');

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
            "foo:$dir/foo",
            "bar:$dir/bar",
            "baz:$dir/baz",
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
