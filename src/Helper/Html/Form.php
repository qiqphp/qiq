<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class Form extends TagHelper
{
    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function __invoke(array $attr = []) : string
    {
        $base = [
            'id' => null,
            'method' => 'post',
            'action' => null,
            'enctype' => 'multipart/form-data',
        ];

        $attr = array_merge($base, $attr);
        return $this->openTag('form', $attr);
    }
}
