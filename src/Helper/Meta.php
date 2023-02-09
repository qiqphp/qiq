<?php
declare(strict_types=1);

namespace Qiq\Helper;

class Meta extends Helper
{
    public function __invoke(array $attr) : string
    {
        return $this->voidTag('meta', $attr);
    }
}
