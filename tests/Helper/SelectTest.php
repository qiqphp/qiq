<?php
namespace Qiq\Helper;

class SelectTest extends HelperTest
{
    public function test()
    {
        $actual = $this->helper([
            'name' => 'field_name',
            'value' => 'opt5',
            'placeholder' => 'Pick One',
            '_options' => [
                'opt1' => 'Label 1',
                'opt2' => 'Label 2',
                'opt3' => 'Label 3',
                'Group A' => [
                    'opt4' => 'Label 4',
                    'opt5' => 'Label 5',
                    'opt6' => 'Label 6',
                ],
                'Group B' => [
                    'opt7' => 'Label 7',
                    'opt8' => 'Label 8',
                    'opt9' => 'Label 9',
                ],
            ],
        ]);

        $expect = '<select name="field_name">' . PHP_EOL
                . '    <option value="" disabled>Pick One</option>' . PHP_EOL
                . '    <option value="opt1">Label 1</option>' . PHP_EOL
                . '    <option value="opt2">Label 2</option>' . PHP_EOL
                . '    <option value="opt3">Label 3</option>' . PHP_EOL
                . '    <optgroup label="Group A">' . PHP_EOL
                . '        <option value="opt4">Label 4</option>' . PHP_EOL
                . '        <option value="opt5" selected>Label 5</option>' . PHP_EOL
                . '        <option value="opt6">Label 6</option>' . PHP_EOL
                . '    </optgroup>' . PHP_EOL
                . '    <optgroup label="Group B">' . PHP_EOL
                . '        <option value="opt7">Label 7</option>' . PHP_EOL
                . '        <option value="opt8">Label 8</option>' . PHP_EOL
                . '        <option value="opt9">Label 9</option>' . PHP_EOL
                . '    </optgroup>' . PHP_EOL
                . '</select>';

        $this->assertSame($expect, $actual);
    }

    public function testMultiple()
    {
        $actual = $this->helper([
            'name' => 'field_name',
            'value' => ['opt2', 'opt5', 'opt8'],
            'multiple' => true,
            '_options' => [
                'opt1' => 'Label 1',
                'opt2' => 'Label 2',
                'opt3' => 'Label 3',
                'Group A' => [
                    'opt4' => 'Label 4',
                    'opt5' => 'Label 5',
                    'opt6' => 'Label 6',
                ],
                'Group B' => [
                    'opt7' => 'Label 7',
                    'opt8' => 'Label 8',
                    'opt9' => 'Label 9',
                ],
            ],
        ]);

        $expect = '<select name="field_name[]" multiple>' . PHP_EOL
                . '    <option value="opt1">Label 1</option>' . PHP_EOL
                . '    <option value="opt2" selected>Label 2</option>' . PHP_EOL
                . '    <option value="opt3">Label 3</option>' . PHP_EOL
                . '    <optgroup label="Group A">' . PHP_EOL
                . '        <option value="opt4">Label 4</option>' . PHP_EOL
                . '        <option value="opt5" selected>Label 5</option>' . PHP_EOL
                . '        <option value="opt6">Label 6</option>' . PHP_EOL
                . '    </optgroup>' . PHP_EOL
                . '    <optgroup label="Group B">' . PHP_EOL
                . '        <option value="opt7">Label 7</option>' . PHP_EOL
                . '        <option value="opt8" selected>Label 8</option>' . PHP_EOL
                . '        <option value="opt9">Label 9</option>' . PHP_EOL
                . '    </optgroup>' . PHP_EOL
                . '</select>';

        $this->assertSame($expect, $actual);
    }
}
