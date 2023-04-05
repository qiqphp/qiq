<?php
namespace Qiq\Helper\Html;

class InputFieldTest extends HtmlHelperTest
{
    public function test() : void
    {
        $actual = $this->helpers->inputField(
            type: 'fake',
            name: 'fake-name',
            value: 'fake-value',
            foo_bar: 'baz',
        );

        $expect = '<input type="fake" name="fake-name" value="fake-value" foo-bar="baz" />';

        $this->assertSame($expect, $actual);
    }
}
