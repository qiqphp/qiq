<?php
namespace Qiq\Helper\Html;

class DlTest extends HtmlHelperTestCase
{
    public function test() : void
    {
        $actual = $this->helpers
            ->dl(
                id: 'test',
                terms: [
                    'foo' => 'Foo Def',
                    'bar' => ['Bar Def A', 'Bar Def B', 'Bar Def C'],
                    'baz' => 'Baz Def',
                ],
            );
        $expect = <<<'HTML'
        <dl id="test">
            <dt>foo</dt>
                <dd>Foo Def</dd>
            <dt>bar</dt>
                <dd>Bar Def A</dd>
                <dd>Bar Def B</dd>
                <dd>Bar Def C</dd>
            <dt>baz</dt>
                <dd>Baz Def</dd>
        </dl>
        HTML;
        $this->assertSame($expect, $actual);
        $actual = $this->helpers->dl([]);
        $expect = '';
        $this->assertSame($expect, $actual);
    }
}
