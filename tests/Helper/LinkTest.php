<?php
namespace Qiq\Helper;

class LinkTest extends HtmlHelperTest
{
    public function test() : void
    {
        $actual = $this->helpers->link('prev', '/path/to/prev', ['foo' => 'bar']);
        $expect = '<link rel="prev" href="/path/to/prev" foo="bar" />';
        $this->assertSame($expect, $actual);
    }
}
