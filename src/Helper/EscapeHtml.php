<?php
declare(strict_types=1);

namespace Qiq\Helper;

class EscapeHtml extends Helper
{
    public function __invoke(mixed $raw) : string
    {
        return $this->escape->h($raw);
    }
}
