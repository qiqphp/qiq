<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class Select extends TagHelper
{
    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $options
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function __invoke(
        string $name,
        mixed $value,
        array $options,
        bool $multiple = false,
        ?string $placeholder = null,
        mixed $default = null,
        array $attr = [],
        mixed ...$__attr
    ) : string
    {
        if ($multiple) {
            $name .= '[]';
        }

        $base = [
            'name' => $name,
            'multiple' => $multiple,
        ];

        unset($attr['name']);
        unset($attr['multiple']);

        /** @var array<null|scalar|\Stringable|array<null|scalar|\Stringable>> */
        $attr = array_merge($base, $attr);

        $html = $this->openTag('select', $attr, $__attr) . PHP_EOL;
        $this->indent->level(+1);

        $selected = $value ?? $default;

        if ($placeholder !== null) {
            /** @var array<null|scalar|\Stringable|array<null|scalar|\Stringable>> */
            $placeholderAttr = [
                'value' => $default ?? "",
                'disabled' => true,
                'selected' => ($selected == $default)
            ];

            $html .= $this->indent->get() . $this->fullTag(
                'option',
                $placeholderAttr,
                $placeholder
            ) . PHP_EOL;
        }

        $html .= $this->options($options, $selected);

        $this->indent->level(-1);

        return $html . $this->indent->get() . '</select>';
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $options
     */
    protected function options(array $options, mixed $selected) : string
    {
        $html = '';

        foreach ($options as $key => $val) {
            $html .= $this->option($key, $val, $selected);
        }

        return $html;
    }

    /**
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $val
     */
    protected function option(int|string $key, mixed $val, mixed $selected) : string
    {
        if (is_array($val)) {
            return $this->optgroup($key, $val, $selected);
        }

        $attr = [];

        $attr['value'] = $key;

        $attr['selected'] = is_array($selected)
            ? in_array($attr['value'], $selected)
            : $attr['value'] == $selected;

        $attr = $this->escape->a($attr);
        $label = $this->escape->h($val);

        return $this->indent->get() . "<option {$attr}>{$label}</option>" . PHP_EOL;
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $options
     */
    public function optgroup(int|string $label, array $options, mixed $selected) : string
    {
        $attr = $this->escape->a(['label' => $label]);

        $this->indent->level(+1);
        $group = $this->options($options, $selected);
        $this->indent->level(-1);

        return $this->indent->get() . "<optgroup $attr>" . PHP_EOL
            . $group
            . $this->indent->get() . "</optgroup>" . PHP_EOL;
    }
}
