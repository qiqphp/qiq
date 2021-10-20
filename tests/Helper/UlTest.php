<?php
namespace Qiq\Helper;

class UlTest extends HelperTest
{
    public function test()
    {
        $actual = $this->helper(
            [
                '>foo',
                '>bar',
                '>baz',
                '>dib',
            ],
            [
                'id' => 'test'
            ],
        );

        $expect = '<ul id="test">' . PHP_EOL
                . '    <li>&gt;foo</li>' . PHP_EOL
                . '    <li>&gt;bar</li>' . PHP_EOL
                . '    <li>&gt;baz</li>' . PHP_EOL
                . '    <li>&gt;dib</li>' . PHP_EOL
                . '</ul>';

        $this->assertSame($expect, $actual);

        $actual = $this->helper([]);
        $expect = '';
        $this->assertSame($expect, $actual);
    }
}
