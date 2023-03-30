<?php
namespace Qiq\Helper\Html;

use Qiq\Indent;

class FieldsAndButtonsTest extends HtmlHelperTest
{
    public function testInputField() : void
    {
        $actual = $this->helpers->inputField(
            type: 'fake',
            name: 'fake-name',
            value: 'fake-value',
            foo_bar: 'baz',
        );

        $expect = '<input type="fake" name="fake-name" value="fake-value" foo-bar="baz" />';

        $this->assertSame($expect, $actual);
    }

    /**
     * @dataProvider provideTypes
     */
    public function testTypes(string $method, string $type) : void
    {
        $actual = $this->helpers->$method(
            name: 'fake-name',
            value: 'fake-value',
            attr: [
                'foo' => 'bar',
            ],
            baz_dib: 'gir',
        );
        $expect = '<input type="' . $type . '" name="fake-name" value="fake-value" foo="bar" baz-dib="gir" />';
        $this->assertSame($expect, $actual);
    }

    /**
     * @return mixed[]
     */
    public function provideTypes() : array
    {
        return [
            ['button', 'button'],
            ['checkboxField', 'checkbox'],
            ['colorField', 'color'],
            ['dateField', 'date'],
            ['datetimeField', 'datetime'],
            ['datetimeLocalField', 'datetime-local'],
            ['emailField', 'email'],
            ['fileField', 'file'],
            ['hiddenField', 'hidden'],
            ['imageButton', 'image'],
            ['monthField', 'month'],
            ['numberField', 'number'],
            ['passwordField', 'password'],
            ['radioField', 'radio'],
            ['rangeField', 'range'],
            ['resetButton', 'reset'],
            ['searchField', 'search'],
            ['submitButton', 'submit'],
            ['telField', 'tel'],
            ['textField', 'text'],
            ['timeField', 'time'],
            ['urlField', 'url'],
            ['weekField', 'week'],
        ];
    }
}
