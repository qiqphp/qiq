<?php
namespace Qiq\Helper\Html;

class ItemsTest extends HtmlHelperTestCase
{
    public function test() : void
    {
        $actual = $this->helpers->items(['>foo', '>bar', '>baz', '>dib']);
        $expect = <<<'HTML'
        <li>&gt;foo</li>
        <li>&gt;bar</li>
        <li>&gt;baz</li>
        <li>&gt;dib</li>

        HTML;
        $this->assertSame($expect, $actual);
    }
}
