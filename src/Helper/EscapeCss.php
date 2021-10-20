<?php
namespace Qiq\Helper;

class EscapeCss extends Helper
{
    public function __invoke(string $raw) : string
    {
        return $this->escape->c($raw);
    }
}
