<?php
namespace Qiq\Helper;

class MetaNameTest extends HtmlHelperTest
{
    public function test() : void
    {
        $actual = $this->helpers->metaName('foo', 'bar');
        $expect = '<meta name="foo" content="bar" />';
        $this->assertSame($expect, $actual);
    }
}
