<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class CheckboxFields extends TagHelper
{
    /**
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $value
     * @param array<null|scalar|\Stringable, null|scalar|\Stringable> $options
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function __invoke(
        ?string $name = null,
        mixed $value = null,
        array $options = [],
        mixed $default = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        unset($attr['type']);
        unset($attr['name']);
        unset($attr['value']);
        $html = '';

        if ($default !== null) {
            $html .= $this->default($name, $default);
        }

        if (count($options) > 1) {
            $name .= '[]';
        }

        foreach ($options as $optionValue => $optionLabel) {
            $html .= $this
                ->checkbox(
                    $name,
                    $value,
                    (string) $optionValue,
                    (string) $optionLabel,
                    $attr,
                    $__attr,
                );
        }

        return ltrim($html);
    }

    protected function default(?string $name, mixed $default) : string
    {
        /** @var array<null|scalar|\Stringable|array<null|scalar|\Stringable>> */
        $attr = ['type' => 'hidden', 'name' => $name, 'value' => $default];
        return $this->indent->get() . $this->voidTag('input', $attr) . PHP_EOL;
    }

    /**
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $__attr
     */
    protected function checkbox(
        ?string $name,
        mixed $value,
        string $optionValue,
        string $optionLabel,
        array $attr,
        array $__attr,
    ) : string
    {
        $base = ['type' => 'checkbox', 'name' => $name, 'value' => $optionValue];

        if (is_array($value)) {
            $attr['checked'] = in_array($optionValue, $value);
        } else {
            $attr['checked'] = $optionValue == $value;
        }

        $attr = array_merge($base, $attr);
        $input = $this->voidTag('input', $attr, $__attr);
        $label = $this->escape->h($optionLabel);
        return $this->indent->get() . "<label>{$input}{$label}</label>" . PHP_EOL;
    }
}
