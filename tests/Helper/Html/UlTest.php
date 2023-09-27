<?php
namespace Qiq\Helper\Html;

class UlTest extends HtmlHelperTestCase
{
    public function test() : void
    {
        $actual = $this->helpers
            ->ul(id: 'test', items: ['>foo', '>bar', '>baz', '>dib']);
        $expect = <<<'HTML'
        <ul id="test">
            <li>&gt;foo</li>
            <li>&gt;bar</li>
            <li>&gt;baz</li>
            <li>&gt;dib</li>
        </ul>
        HTML;
        $this->assertSameString($expect, $actual);
        $actual = $this->helpers->ul([]);
        $expect = '';
        $this->assertSameString($expect, $actual);
    }
}
