<?php
namespace Qiq\Helper;

class LabelTest extends HtmlHelperTest
{
    public function test() : void
    {
        $attr = [
            'for' => 'bar',
            'class' => 'zim'
        ];
        $actual = $this->helpers->label('Foo', $attr);
        $expect = '<label for="bar" class="zim">Foo</label>';
        $this->assertSame($actual, $expect);
    }
}
