<?php
namespace Qiq\Helper;

class MetaTest extends HtmlHelperTest
{
    public function test() : void
    {
        $actual = $this->helpers->meta(['charset' => 'utf-8']);
        $expect = '<meta charset="utf-8" />';
        $this->assertSame($expect, $actual);
    }
}
