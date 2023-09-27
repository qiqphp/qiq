<?php
namespace Qiq\Helper\Html;

class ImageTest extends HtmlHelperTestCase
{
    public function test() : void
    {
        $src = '/images/example.gif';
        $actual = $this->helpers->image($src);
        $expect = '<img src="/images/example.gif" alt="example.gif" />';
        $this->assertSame($actual, $expect);
    }
}
