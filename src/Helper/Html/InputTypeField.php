<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

abstract class InputTypeField extends TagHelper
{
    protected string $type;

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function __invoke(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr
    ) : string
    {
        $base = array(
            'id' => null,
            'type' => $this->type,
            'name' => $name,
            'value' => $value,
        );

        unset($attr['type']);
        unset($attr['name']);
        unset($attr['value']);

        $attr = array_merge($base, $attr);
        return $this->voidTag('input', $attr, $__attr);
    }
}
