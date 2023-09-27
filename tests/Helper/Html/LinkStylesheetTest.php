<?php
namespace Qiq\Helper\Html;

class LinkStylesheetTest extends HtmlHelperTestCase
{
    public function test() : void
    {
        $actual = $this->helpers->linkStylesheet('style.css');
        $expect = '<link rel="stylesheet" href="style.css" type="text/css" media="screen" />';
        $this->assertSame($expect, $actual);
    }
}
