<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class Meta extends TagHelper
{
    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function __invoke(array $attr = [], mixed ...$__attr) : string
    {
        return $this->voidTag('meta', $attr, $__attr);
    }
}
