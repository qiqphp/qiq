<?php
namespace Qiq\Helper\Html;

class ItemsTest extends HtmlHelperTest
{
    public function test() : void
    {
        $actual = $this->helpers->items([
            '>foo',
            '>bar',
            '>baz',
            '>dib',
        ]);

        $expect = '<li>&gt;foo</li>' . PHP_EOL
                . '<li>&gt;bar</li>' . PHP_EOL
                . '<li>&gt;baz</li>' . PHP_EOL
                . '<li>&gt;dib</li>' . PHP_EOL;

        $this->assertSame($expect, $actual);
    }
}
