<?php
namespace Qiq\Helper;

use Qiq\Indent;

class CheckboxField extends InputField
{
    protected string $type = 'checkbox';

    public function __invoke(array $attr) : string
    {
        if (! isset($attr['_options'])) {
            return parent::__invoke($attr);
        }

        $base = [
            'type' => 'checkbox',
            'name' => null,
            'value' => null,
            '_options' => [],
        ];

        $attr = array_merge($base, $attr);

        $options = (array) $attr['_options'];
        unset($attr['_options']);

        $html = '';

        if (array_key_exists('_default', $attr)) {
            $default = $attr['_default'];
            unset($attr['_default']);
            $html .= $this->default($attr, $default);
        }

        $checked = $attr['value'];

        if (count($options) > 1) {
            $attr['name'] .= '[]';
        }

        foreach ($options as $value => $label) {
            $html .= $this->checkbox($attr, $value, $label, $checked);
        }

        return ltrim($html);
    }

    protected function default(array $attr, mixed $default) : string
    {
        $attr = [
            'type' => 'hidden',
            'name' => $attr['name'],
            'value' => $default,
        ];

        return Indent::get() . $this->voidTag('input', $attr) . PHP_EOL;
    }

    protected function checkbox(
        array $attr,
        mixed $value,
        string $label,
        mixed $checked,
    ) : string
    {
        if (is_array($checked)) {
            $attr['checked'] = in_array($value, $checked);
        } else {
            $attr['checked'] = ($value == $checked);
        }

        $attr['type'] = 'checkbox';
        $attr['value'] = $value;
        $attr = $this->escape->a($attr);
        $label = $this->escape->h($label);
        return Indent::get() . "<label><input {$attr} />{$label}</label>" . PHP_EOL;
    }
}
