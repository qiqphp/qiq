<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class Form extends TagHelper
{
    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function __invoke(
        string $action,
        string $method = 'post',
        string $enctype = 'multipart/form-data',
        array $attr = [],
        mixed ...$__attr
    ) : string
    {
        $base = [
            'method' => $method,
            'action' => $action,
            'enctype' => $enctype,
        ];

        unset($attr['action']);
        unset($attr['method']);
        unset($attr['enctype']);

        $attr = array_merge($base, $attr);
        return $this->openTag('form', $attr, $__attr);
    }
}
