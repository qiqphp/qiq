<?php
namespace Qiq\Helper\Html;

class OlTest extends HtmlHelperTest
{
    public function test() : void
    {
        $actual = $this->helpers->ol(
            id: 'test',
            items: [
                '>foo',
                '>bar',
                '>baz',
                '>dib',
            ],
        );

        $expect = '<ol id="test">' . PHP_EOL
                . '    <li>&gt;foo</li>' . PHP_EOL
                . '    <li>&gt;bar</li>' . PHP_EOL
                . '    <li>&gt;baz</li>' . PHP_EOL
                . '    <li>&gt;dib</li>' . PHP_EOL
                . '</ol>';

        $this->assertSame($expect, $actual);

        $actual = $this->helpers->ol([]);
        $expect = '';
        $this->assertSame($expect, $actual);
    }
}
