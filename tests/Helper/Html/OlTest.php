<?php
namespace Qiq\Helper\Html;

class OlTest extends HtmlHelperTestCase
{
    public function test() : void
    {
        $actual = $this->helpers
            ->ol(id: 'test', items: ['>foo', '>bar', '>baz', '>dib']);
        $expect = <<<'HTML'
        <ol id="test">
            <li>&gt;foo</li>
            <li>&gt;bar</li>
            <li>&gt;baz</li>
            <li>&gt;dib</li>
        </ol>
        HTML;
        $this->assertSameString($expect, $actual);
        $actual = $this->helpers->ol([]);
        $expect = '';
        $this->assertSameString($expect, $actual);
    }
}
