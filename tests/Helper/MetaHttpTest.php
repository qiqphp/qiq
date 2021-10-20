<?php
namespace Qiq\Helper;

class MetaHttpTest extends HelperTest
{
    public function test()
    {
        $actual = $this->helper('Location', '/redirect/to/here/');
        $expect = '<meta http-equiv="Location" content="/redirect/to/here/" />';
        $this->assertSame($expect, $actual);
    }
}
