<?php
namespace Qiq\Helper;

class EscapeJs extends Helper
{
    public function __invoke(string $raw) : string
    {
        return $this->escape->j($raw);
    }
}
