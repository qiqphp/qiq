<?php
namespace Qiq\Helper;

class BaseTest extends HtmlHelperTest
{
    public function test() : void
    {
        $href = '/path/to/base';
        $actual = $this->helpers->base($href);
        $expect = '<base href="/path/to/base" />';
        $this->assertSame($expect, $actual);
    }
}
