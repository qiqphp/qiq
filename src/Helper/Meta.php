<?php
namespace Qiq\Helper;

class Meta extends Helper
{
    public function __invoke(array $attr) : string
    {
        return $this->voidTag('meta', $attr);
    }
}
