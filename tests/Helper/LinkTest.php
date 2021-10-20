<?php
namespace Qiq\Helper;

class LinkTest extends HelperTest
{
    public function test()
    {
        $actual = $this->helper('prev', '/path/to/prev', ['foo' => 'bar']);
        $expect = '<link rel="prev" href="/path/to/prev" foo="bar" />';
        $this->assertSame($expect, $actual);
    }
}
