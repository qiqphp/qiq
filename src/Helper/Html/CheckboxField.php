<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

use Qiq\Indent;

class CheckboxField extends InputField
{
    protected string $type = 'checkbox';

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>>|array<array<null|scalar|\Stringable|array<null|scalar|\Stringable>>> $attr
     */
    public function __invoke(array $attr) : string
    {
        if (! isset($attr['_options'])) {
            /** @var array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr */
            return parent::__invoke($attr);
        }

        $base = [
            'type' => 'checkbox',
            'name' => null,
            'value' => null,
            '_options' => [],
        ];

        /** @var array<null|scalar|\Stringable|array<null|scalar|\Stringable>>|array<array<null|scalar|\Stringable|array<null|scalar|\Stringable>>> */
        $attr = array_merge($base, $attr);

        $options = (array) $attr['_options'];
        unset($attr['_options']);

        /** @var array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr */
        settype($attr['name'], 'string');
        assert(is_string($attr['name']));

        $html = '';

        if (array_key_exists('_default', $attr)) {
            $default = $attr['_default'];
            unset($attr['_default']);
            $html .= $this->default($attr['name'], $default);
        }

        $checked = $attr['value'];

        if (count($options) > 1) {
            $attr['name'] .= '[]';
        }

        foreach ($options as $value => $label) {
            $html .= $this->checkbox(
                $attr,
                (string) $value,
                (string) $label,
                $checked
            );
        }

        return ltrim($html);
    }

    protected function default(string $name, mixed $default) : string
    {
        /** @var array<null|scalar|\Stringable|array<null|scalar|\Stringable>> */
        $attr = [
            'type' => 'hidden',
            'name' => $name,
            'value' => $default,
        ];

        return $this->indent->get() . $this->voidTag('input', $attr) . PHP_EOL;
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    protected function checkbox(
        array $attr,
        string $value,
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
        return $this->indent->get() . "<label><input {$attr} />{$label}</label>" . PHP_EOL;
    }
}
