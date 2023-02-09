<?php
declare(strict_types=1);

namespace Qiq\Helper;

class CheckboxFieldTest extends HelperTest
{
    public function test()
    {
        $actual = $this->helper([
            'name' => 'foo',
            'value' => ['yes', 'no'],
            '_default' => '',
            '_options' => [
                'yes' => 'Yes',
                'no' => 'No',
                'maybe' => 'May & be'
            ]
        ]);

        $expect = '<input type="hidden" name="foo" value="" />' . PHP_EOL
            . '<label><input type="checkbox" name="foo[]" value="yes" checked />Yes</label>' . PHP_EOL
            . '<label><input type="checkbox" name="foo[]" value="no" checked />No</label>' . PHP_EOL
            . '<label><input type="checkbox" name="foo[]" value="maybe" />May &amp; be</label>' . PHP_EOL;

        $this->assertSame($expect, $actual);
    }

    public function testSingleOption()
    {
        $actual = $this->helper([
            'name' => 'foo',
            'value' => '1',
            '_default' => '0',
            '_options' => [
                '1' => 'Yes',
            ]
        ]);

        $expect = '<input type="hidden" name="foo" value="0" />' . PHP_EOL
            . '<label><input type="checkbox" name="foo" value="1" checked />Yes</label>' . PHP_EOL;

        $this->assertSame($expect, $actual);
    }

    public function testScalarChecked()
    {
        $actual = $this->helper([
            'name' => 'foo',
            'value' => 'no',
            '_options' => [
                'yes' => 'Yes',
                'no' => 'No',
                'maybe' => 'May & be'
            ]
        ]);

        $expect = '<label><input type="checkbox" name="foo[]" value="yes" />Yes</label>' . PHP_EOL
            . '<label><input type="checkbox" name="foo[]" value="no" checked />No</label>' . PHP_EOL
            . '<label><input type="checkbox" name="foo[]" value="maybe" />May &amp; be</label>' . PHP_EOL;

        $this->assertSame($expect, $actual);
    }
}
