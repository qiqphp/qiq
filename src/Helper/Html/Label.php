<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class Label extends TagHelper
{
    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function __invoke(string $text, array $attr = [], mixed ...$__attr) : string
    {
        $attr = array_merge(['id' => null], $attr);
        return $this->fullTag('label', $attr, $text, $__attr);
    }
}
