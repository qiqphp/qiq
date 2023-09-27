<?php
namespace Qiq\Helper\Html;

class CheckboxFieldsTest extends HtmlHelperTestCase
{
    public function test() : void
    {
        $actual = $this->helpers
            ->checkboxFields(
                name: 'foo',
                value: ['yes', 'no'],
                default: '',
                options: ['yes' => 'Yes', 'no' => 'No', 'maybe' => 'May & be'],
            );
        $expect = <<<'HTML'
        <input type="hidden" name="foo" value="" />
        <label><input type="checkbox" name="foo[]" value="yes" checked />Yes</label>
        <label><input type="checkbox" name="foo[]" value="no" checked />No</label>
        <label><input type="checkbox" name="foo[]" value="maybe" />May &amp; be</label>

        HTML;
        $this->assertSame($expect, $actual);
    }

    public function testSingleOption() : void
    {
        $actual = $this->helpers
            ->checkboxFields(
                name: 'foo',
                value: '1',
                default: '0',
                options: ['1' => 'Yes'],
            );
        $expect = <<<'HTML'
        <input type="hidden" name="foo" value="0" />
        <label><input type="checkbox" name="foo" value="1" checked />Yes</label>

        HTML;
        $this->assertSame($expect, $actual);
    }

    public function testScalarChecked() : void
    {
        $actual = $this->helpers
            ->checkboxFields(
                name: 'foo',
                value: 'no',
                options: ['yes' => 'Yes', 'no' => 'No', 'maybe' => 'May & be'],
            );
        $expect = <<<'HTML'
        <label><input type="checkbox" name="foo[]" value="yes" />Yes</label>
        <label><input type="checkbox" name="foo[]" value="no" checked />No</label>
        <label><input type="checkbox" name="foo[]" value="maybe" />May &amp; be</label>

        HTML;
        $this->assertSame($expect, $actual);
    }
}
