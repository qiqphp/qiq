<?php
declare(strict_types=1);

namespace Qiq\Helper;

use Qiq\Indent;

class Select extends Helper
{
    public function __invoke(array $attr) : string
    {
        $base = [
            'name' => null,
        ];

        $attr = array_merge($base, $attr);

        $placeholder = $attr['placeholder'] ?? null;
        unset($attr['placeholder']);

        $options = $attr['_options'] ?? [];
        unset($attr['_options']);

        $default = $attr['_default'] ?? '';
        unset($attr['_default']);

        $selected = $attr['value'] ?? $default;
        unset($attr['value']);

        if ($attr['multiple'] ?? false) {
            $attr['name'] .= '[]';
        }

        $html = $this->openTag('select', $attr) . PHP_EOL;
        Indent::level(+1);

        if ($placeholder !== null) {
            $html .= Indent::get() . $this->fullTag(
                'option',
                [
                    'value' => $default,
                    'disabled' => true,
                    'selected' => ($selected == $default)
                ],
                $placeholder
            ) . PHP_EOL;
        }

        $html .= $this->options($options, $selected);

        Indent::level(-1);

        return $html . Indent::get() . '</select>';
    }

    protected function options(array $options, mixed $selected) : string
    {
        $html = '';

        foreach ($options as $key => $val) {
            $html .= $this->option($key, $val, $selected);
        }

        return $html;
    }

    /**
     * @param int|string $key
     * @param null|scalar|array $val
     */
    protected function option(mixed $key, mixed $val, mixed $selected) : string
    {
        if (is_array($val)) {
            return $this->optgroup((string) $key, $val, $selected);
        }

        $attr = [];

        $attr['value'] = $key;

        $attr['selected'] = is_array($selected)
            ? in_array($attr['value'], $selected)
            : $attr['value'] == $selected;

        $attr = $this->escape->a($attr);
        $label = $this->escape->h((string) $val);

        return Indent::get() . "<option {$attr}>{$label}</option>" . PHP_EOL;
    }

    public function optgroup(string $label, array $options, mixed $selected) : string
    {
        $attr = $this->escape->a(['label' => $label]);

        Indent::level(+1);
        $group = $this->options($options, $selected);
        Indent::level(-1);

        return Indent::get() . "<optgroup $attr>" . PHP_EOL
            . $group
            . Indent::get() . "</optgroup>" . PHP_EOL;
    }
}
