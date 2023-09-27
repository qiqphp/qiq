<?php
declare(strict_types=1);

namespace Qiq;

use Qiq\Assertions;
use Qiq\Compiler\NonCompiler;
use Qiq\Compiler\QiqCompiler;
use RuntimeException;

class TemplateTest extends \PHPUnit\Framework\TestCase
{
    use Assertions;

    protected HtmlTemplate $template;

    protected function setUp() : void
    {
        $this->template = HtmlTemplate::new(
            paths: __DIR__ . '/templates',
            cachePath: dirname(__DIR__)
                . DIRECTORY_SEPARATOR
                . 'tmp'
                . DIRECTORY_SEPARATOR
                . 'cache',
        );
    }

    public function testStaticNew() : void
    {
        $this->assertInstanceOf(Template::CLASS, Template::new());
    }

    public function test__call() : void
    {
        $actual = $this->template->h('foo & bar');
        $this->assertSame('foo &amp; bar', $actual);
    }

    public function testGetters() : void
    {
        $this->assertInstanceOf(Catalog::CLASS, $this->template->getCatalog());
        $this->assertInstanceOf(Helpers::CLASS, $this->template->getHelpers());
    }

    public function testSetAddAndGetData() : void
    {
        $expect = ['foo' => 'bar'];
        $this->template->setData(['foo' => 'bar']);
        $this->assertSame($expect, $this->template->getData());
        $expect['baz'] = 'dib';
        $this->template->addData(['baz' => 'dib']);
        $this->assertSame($expect, $this->template->getData());
    }

    public function testInvokeOneStep() : void
    {
        $this->template->setData(['name' => 'Index']);
        $this->template->setView('index');
        $actual = ($this->template)();
        $expect = "Hello Index!";
        $this->assertSame($expect, $actual);
    }

    public function testInvokeTwoStep() : void
    {
        $this->template->setData(['name' => 'Index', 'title' => 'Default Title']);
        $this->template->setView('index');
        $this->template->setLayout('layout/default');
        $actual = ($this->template)();
        $expect = "Index Title -- before -- Hello Index! -- after";
        $this->assertSame($expect, $actual);
    }

    public function testPartial() : void
    {
        $this->template->setView('master');
        $actual = ($this->template)();
        $expect = "foo = bar" . PHP_EOL . "foo = baz" . PHP_EOL . "foo = dib" . PHP_EOL;
        $this->assertSame($expect, $actual);
    }

    public function testException() : void
    {
        $this->template->setView('exception');
        $this->expectException(RuntimeException::CLASS);
        $actual = ($this->template)();
    }

    public function testRelative() : void
    {
        $this->template->setView('rel/foo');
        $actual = ($this->template)();
        $this->assertSame('foobarbazdibdib', $actual);
    }

    public function testRelativeFailure() : void
    {
        $this->template->setView('rel/foo/broken');

        try {
            ($this->template)();
        } catch (Exception\FileNotFound $e) {
            $expect = <<<'EXPECT'
            Could not resolve dots in template name.
            Original name: '../../../zim'
            Resolved into: '../zim'
            Probably too many '../' in the original name.
            EXPECT;
            $actual = $e->getMessage();
            $this->assertSameString(trim($expect), trim($actual));
            return;
        }

        throw new RuntimeException('Should have thrown exception');
    }

    public function testExtends() : void
    {
        $this->template->setView('ext/view-3');
        $this->template->setLayout('ext/layout-3');
        $expect = <<<EOT
        Layout 1 Content
        View 1 Content
        Foo 3a View
        Foo 1 Layout
        Foo 2 Layout
        Foo 3 Layout
        Foo 1 View
        Foo 2 View
        Foo 3b View
        EOT;
        $actual = ($this->template)();
        $actual = str_replace("\n\n", "\n", $actual);
        $this->assertSameString(trim($expect), trim($actual));
    }

    public function testInheritanceDocExample() : void
    {
        $this->template->setView('ext/child');
        $expect = <<<'HTML'
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <title>
                My Extended Page
            </title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="stylesheet" href="/theme/basic.css" type="text/css" media="screen" />
            <link rel="stylesheet" href="/theme/custom.css" type="text/css" media="screen" />
        </head>
        <body>
            <p>The main content for my extended page.</p>
        </body>
        </html>

        HTML;
        $actual = ($this->template)();
        $this->assertSame($expect, $actual);
    }

    public function testNonCompiler() : void
    {
        $template = Template::new(cachePath: false);
        $actual = $template->getCatalog()->getCompiler();
        $this->assertInstanceOf(NonCompiler::class, $actual);
    }
}
