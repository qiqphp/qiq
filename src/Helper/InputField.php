<?php
declare(strict_types=1);

namespace Qiq\Helper;

class InputField extends Helper
{
    protected string $type = '';

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
