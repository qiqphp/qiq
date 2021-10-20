<?php
namespace Qiq\Helper;

class TextareaTest extends HelperTest
{
    public function test()
    {
        $actual = $this->helper([
            'name' => 'field',
            'value' => "the quick & brown fox",
        ]);

        $expect = '<textarea name="field">the quick &amp; brown fox</textarea>';

        $this->assertSame($expect, $actual);
    }
}
