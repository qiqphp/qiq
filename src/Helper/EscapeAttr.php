<?php
namespace Qiq\Helper;

class EscapeAttr extends Helper
{
    public function __invoke(string|array $raw) : string
    {
        return $this->escape->a($raw);
    }
}
