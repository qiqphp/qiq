<?php
namespace Qiq\Helper\Html;

class UlTest extends HtmlHelperTest
{
    public function test() : void
    {
        $actual = $this->helpers->ul(
            id: 'test',
            items: [
                '>foo',
                '>bar',
                '>baz',
                '>dib',
            ],
        );

        $expect = '<ul id="test">' . PHP_EOL
                . '    <li>&gt;foo</li>' . PHP_EOL
                . '    <li>&gt;bar</li>' . PHP_EOL
                . '    <li>&gt;baz</li>' . PHP_EOL
                . '    <li>&gt;dib</li>' . PHP_EOL
                . '</ul>';

        $this->assertSame($expect, $actual);

        $actual = $this->helpers->ul([]);
        $expect = '';
        $this->assertSame($expect, $actual);
    }
}
