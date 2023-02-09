<?php
declare(strict_types=1);

namespace Qiq\Helper;

class LinkStylesheetTest extends HelperTest
{
    public function test()
    {
        $actual = $this->helper('style.css');
        $expect = '<link rel="stylesheet" href="style.css" type="text/css" media="screen" />';
        $this->assertSame($expect, $actual);
    }
}
