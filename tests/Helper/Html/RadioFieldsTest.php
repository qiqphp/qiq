<?php
namespace Qiq\Helper\Html;

class RadioFieldsTest extends HtmlHelperTestCase
{
    public function test() : void
    {
        $actual = $this->helpers
            ->radioFields(
                name: 'foo',
                value: 'no',
                default: '',
                options: ['yes' => 'Yes', 'no' => 'No', 'maybe' => 'May & be'],
            );
        $expect = <<<'HTML'
        <input type="hidden" name="foo" value="" />
        <label><input type="radio" name="foo" value="yes" />Yes</label>
        <label><input type="radio" name="foo" value="no" checked />No</label>
        <label><input type="radio" name="foo" value="maybe" />May &amp; be</label>

        HTML;
        $this->assertSame($expect, $actual);
    }
}
