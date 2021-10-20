<?php
namespace Qiq\Helper;

class Base extends Helper
{
    public function __invoke(string $href) : string
    {
        return $this->voidTag('base', ['href' => $href]);
    }
}
