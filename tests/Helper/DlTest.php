<?php
namespace Qiq\Helper;

class DlTest extends HtmlHelperTest
{
    public function test() : void
    {
        $actual = $this->helpers->dl(
            [
                'foo' => 'Foo Def',
                'bar' => [
                    'Bar Def A',
                    'Bar Def B',
                    'Bar Def C',
                ],
                'baz' => 'Baz Def',
            ],
            [
                'id' => 'test'
            ],
        );

        $expect = '<dl id="test">' . PHP_EOL
                . '    <dt>foo</dt>' . PHP_EOL
                . '        <dd>Foo Def</dd>' . PHP_EOL
                . '    <dt>bar</dt>' . PHP_EOL
                . '        <dd>Bar Def A</dd>' . PHP_EOL
                . '        <dd>Bar Def B</dd>' . PHP_EOL
                . '        <dd>Bar Def C</dd>' . PHP_EOL
                . '    <dt>baz</dt>' . PHP_EOL
                . '        <dd>Baz Def</dd>' . PHP_EOL
                . '</dl>';

        $this->assertSame($expect, $actual);

        $actual = $this->helpers->dl([]);
        $expect = '';
        $this->assertSame($expect, $actual);
    }
}
