<?php
namespace Qiq\Helper\Html;

class CheckboxFieldTest extends HtmlHelperTest
{
    public function test() : void
    {
        $actual = $this->helpers->checkboxFields(
            name: 'foo',
            value: ['yes', 'no'],
            default: '',
            options: [
                'yes' => 'Yes',
                'no' => 'No',
                'maybe' => 'May & be'
            ]
        );

        $expect = '<input type="hidden" name="foo" value="" />' . PHP_EOL
            . '<label><input type="checkbox" name="foo[]" value="yes" checked />Yes</label>' . PHP_EOL
            . '<label><input type="checkbox" name="foo[]" value="no" checked />No</label>' . PHP_EOL
            . '<label><input type="checkbox" name="foo[]" value="maybe" />May &amp; be</label>' . PHP_EOL;

        $this->assertSame($expect, $actual);
    }

    public function testSingleOption() : void
    {
        $actual = $this->helpers->checkboxFields(
            name: 'foo',
            value: '1',
            default: '0',
            options: [
                '1' => 'Yes',
            ]
        );

        $expect = '<input type="hidden" name="foo" value="0" />' . PHP_EOL
            . '<label><input type="checkbox" name="foo" value="1" checked />Yes</label>' . PHP_EOL;

        $this->assertSame($expect, $actual);
    }

    public function testScalarChecked() : void
    {
        $actual = $this->helpers->checkboxFields(
            name: 'foo',
            value: 'no',
            options: [
                'yes' => 'Yes',
                'no' => 'No',
                'maybe' => 'May & be'
            ]
        );

        $expect = '<label><input type="checkbox" name="foo[]" value="yes" />Yes</label>' . PHP_EOL
            . '<label><input type="checkbox" name="foo[]" value="no" checked />No</label>' . PHP_EOL
            . '<label><input type="checkbox" name="foo[]" value="maybe" />May &amp; be</label>' . PHP_EOL;

        $this->assertSame($expect, $actual);
    }
}
