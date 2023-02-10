<?php
namespace Qiq\Helper;

class TextareaTest extends HtmlHelperTest
{
    public function test() : void
    {
        $actual = $this->helpers->textarea([
            'name' => 'field',
            'value' => "the quick & brown fox",
        ]);

        $expect = '<textarea name="field">the quick &amp; brown fox</textarea>';

        $this->assertSame($expect, $actual);
    }
}
