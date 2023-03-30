<?php
namespace Qiq\Helper\Html;

class RadioFieldsTest extends HtmlHelperTest
{
    public function test() : void
    {
        $actual = $this->helpers->radioFields(
            name: 'foo',
            value: 'no',
            default: '',
            options: [
                'yes' => 'Yes',
                'no' => 'No',
                'maybe' => 'May & be'
            ]
        );

        $expect = '<input type="hidden" name="foo" value="" />' . PHP_EOL
            . '<label><input type="radio" name="foo" value="yes" />Yes</label>' . PHP_EOL
            . '<label><input type="radio" name="foo" value="no" checked />No</label>' . PHP_EOL
            . '<label><input type="radio" name="foo" value="maybe" />May &amp; be</label>' . PHP_EOL;

        $this->assertSame($expect, $actual);
    }
}
