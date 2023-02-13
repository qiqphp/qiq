<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class Meta extends TagHelper
{
    /**
     * @param stringy-attr $attr
     */
    public function __invoke(array $attr) : string
    {
        return $this->voidTag('meta', $attr);
    }
}
