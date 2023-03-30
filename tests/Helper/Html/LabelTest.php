<?php
namespace Qiq\Helper\Html;

class LabelTest extends HtmlHelperTest
{
    public function test() : void
    {
        $actual = $this->helpers->label(
            'Foo',
            for: 'bar',
            class: 'zim',
        );
        $expect = '<label for="bar" class="zim">Foo</label>';
        $this->assertSame($actual, $expect);
    }
}
