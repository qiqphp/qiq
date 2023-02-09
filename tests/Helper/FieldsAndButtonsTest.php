<?php
declare(strict_types=1);

namespace Qiq\Helper;

use Qiq\Escape;

class InputFieldTest extends HelperTest
{
    protected function newHelper()
    {
        return new InputField(new Escape());
    }

    public function testInputField()
    {
        $actual = $this->helper([
            'type' => 'fake',
            'name' => 'fake-name',
            'value' => 'fake-value',
        ]);

        $expect = '<input type="fake" name="fake-name" value="fake-value" />';

        $this->assertSame($expect, $actual);
    }

    /**
     * @dataProvider provideTypes
     */
    public function testTypes(string $class, string $type)
    {
        $input = new $class(new Escape());
        $actual = $input([
            'name' => 'fake-name',
            'value' => 'fake-value',
        ]);
        $expect = '<input type="' . $type . '" name="fake-name" value="fake-value" />';
        $this->assertSame($expect, $actual);
    }

    public function provideTypes()
    {
        return [
            [CheckboxField::CLASS, 'checkbox'],
            [ColorField::CLASS, 'color'],
            [DateField::CLASS, 'date'],
            [DatetimeField::CLASS, 'datetime'],
            [DatetimeLocalField::CLASS, 'datetime-local'],
            [EmailField::CLASS, 'email'],
            [FileField::CLASS, 'file'],
            [HiddenField::CLASS, 'hidden'],
            [ImageButton::CLASS, 'image'],
            [MonthField::CLASS, 'month'],
            [NumberField::CLASS, 'number'],
            [PasswordField::CLASS, 'password'],
            [RadioField::CLASS, 'radio'],
            [RangeField::CLASS, 'range'],
            [ResetButton::CLASS, 'reset'],
            [SearchField::CLASS, 'search'],
            [SubmitButton::CLASS, 'submit'],
            [TelField::CLASS, 'tel'],
            [TextField::CLASS, 'text'],
            [TimeField::CLASS, 'time'],
            [UrlField::CLASS, 'url'],
            [WeekField::CLASS, 'week'],
        ];
    }
}
