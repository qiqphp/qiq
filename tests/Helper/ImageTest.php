<?php
namespace Qiq\Helper;

class ImageTest extends HelperTest
{
    public function test()
    {
        $src = '/images/example.gif';
        $actual = $this->helper($src);
        $expect = '<img src="/images/example.gif" alt="example.gif" />';
        $this->assertSame($actual, $expect);
    }
}
