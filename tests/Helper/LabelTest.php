<?php
declare(strict_types=1);

namespace Qiq\Helper;

class LabelTest extends HelperTest
{
    public function test()
    {
        $attr = [
            'for' => 'bar',
            'class' => 'zim'
        ];
        $actual = $this->helper('Foo', $attr);
        $expect = '<label for="bar" class="zim">Foo</label>';
        $this->assertSame($actual, $expect);
    }
}
