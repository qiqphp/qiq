<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class InputField extends TagHelper
{
    protected string $type = '';

    /**
     * @param stringy-attr $attr
     */
    public function __invoke(array $attr) : string
    {
        $base = array(
            'id' => null,
            'type' => null,
            'name' => null,
            'value' => null,
        );

        if ($this->type !== '') {
            $base['type'] = $this->type;
            unset($attr['type']);
        }

        $attr = array_merge($base, $attr);
        return $this->voidTag('input', $attr);
    }
}
