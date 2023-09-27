<?php
namespace Qiq\Helper\Html;

class SelectTest extends HtmlHelperTestCase
{
    public function test() : void
    {
        $actual = $this->helpers
            ->select(
                name: 'field_name',
                value: 'opt5',
                placeholder: 'Pick One',
                options: [
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
            );
        $expect = <<<'HTML'
        <select name="field_name">
            <option value="" disabled>Pick One</option>
            <option value="opt1">Label 1</option>
            <option value="opt2">Label 2</option>
            <option value="opt3">Label 3</option>
            <optgroup label="Group A">
                <option value="opt4">Label 4</option>
                <option value="opt5" selected>Label 5</option>
                <option value="opt6">Label 6</option>
            </optgroup>
            <optgroup label="Group B">
                <option value="opt7">Label 7</option>
                <option value="opt8">Label 8</option>
                <option value="opt9">Label 9</option>
            </optgroup>
        </select>
        HTML;
        $this->assertSame($expect, $actual);
    }

    public function testMultiple() : void
    {
        $actual = $this->helpers
            ->select(
                name: 'field_name',
                value: ['opt2', 'opt5', 'opt8'],
                multiple: true,
                options: [
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
            );
        $expect = <<<'HTML'
        <select name="field_name[]" multiple>
            <option value="opt1">Label 1</option>
            <option value="opt2" selected>Label 2</option>
            <option value="opt3">Label 3</option>
            <optgroup label="Group A">
                <option value="opt4">Label 4</option>
                <option value="opt5" selected>Label 5</option>
                <option value="opt6">Label 6</option>
            </optgroup>
            <optgroup label="Group B">
                <option value="opt7">Label 7</option>
                <option value="opt8" selected>Label 8</option>
                <option value="opt9">Label 9</option>
            </optgroup>
        </select>
        HTML;
        $this->assertSame($expect, $actual);
    }
}
