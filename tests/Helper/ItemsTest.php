<?php
namespace Qiq\Helper;

class ItemsTest extends HelperTest
{
    public function test()
    {
        $actual = $this->helper([
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
