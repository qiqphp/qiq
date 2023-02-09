<?php
declare(strict_types=1);

namespace Qiq\Helper;

class ScriptTest extends HelperTest
{
    public function test()
    {
        $actual = $this->helper('script.js');
        $expect = '<script src="script.js" type="text/javascript"></script>';
        $this->assertSame($expect, $actual);
    }
}
