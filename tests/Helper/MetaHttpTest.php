<?php
namespace Qiq\Helper;

class MetaHttpTest extends HtmlHelperTest
{
    public function test() : void
    {
        $actual = $this->helpers->metaHttp('Location', '/redirect/to/here/');
        $expect = '<meta http-equiv="Location" content="/redirect/to/here/" />';
        $this->assertSame($expect, $actual);
    }
}
