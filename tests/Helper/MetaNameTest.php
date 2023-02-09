<?php
declare(strict_types=1);

namespace Qiq\Helper;

class MetaNameTest extends HelperTest
{
    public function test()
    {
        $actual = $this->helper('foo', 'bar');
        $expect = '<meta name="foo" content="bar" />';
        $this->assertSame($expect, $actual);
    }
}
