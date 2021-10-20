<?php
namespace Qiq\Helper;

class EscapeHtml extends Helper
{
    public function __invoke(string $raw) : string
    {
        return $this->escape->h($raw);
    }
}
