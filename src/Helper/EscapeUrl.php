<?php
namespace Qiq\Helper;

class EscapeUrl extends Helper
{
    public function __invoke(string $raw) : string
    {
        return $this->escape->u($raw);
    }
}
