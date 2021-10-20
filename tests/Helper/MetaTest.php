<?php
namespace Qiq\Helper;

class MetaTest extends HelperTest
{
    public function test()
    {
        $actual = $this->helper(['charset' => 'utf-8']);
        $expect = '<meta charset="utf-8" />';
        $this->assertSame($expect, $actual);
    }
}
