<?php
namespace Qiq\Helper;

class BaseTest extends HelperTest
{
    public function test()
    {
        $href = '/path/to/base';
        $actual = $this->helper($href);
        $expect = '<base href="/path/to/base" />';
        $this->assertSame($expect, $actual);
    }
}
