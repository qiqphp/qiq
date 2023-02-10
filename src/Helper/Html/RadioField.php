<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

use Qiq\Indent;

class RadioField extends InputField
{
    protected string $type = 'radio';

    public function __invoke(array $attr) : string
    {
        if (! isset($attr['_options'])) {
            return parent::__invoke($attr);
        }

        $base = [
            'type' => 'radio',
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

        foreach ($options as $value => $label) {
            $html .= $this->radio($attr, $value, $label, $checked);
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

        return $this->indent->get() . $this->voidTag('input', $attr) . PHP_EOL;
    }

    protected function radio(array $attr, mixed $value, string $label, mixed $checked) : string
    {
        $attr['type'] = 'radio';
        $attr['value'] = $value;
        $attr['checked'] = ($value == $checked);
        $attr = $this->escape->a($attr);
        $label = $this->escape->h($label);
        return $this->indent->get() . "<label><input {$attr} />{$label}</label>" . PHP_EOL;
    }
}
