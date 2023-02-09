<?php
declare(strict_types=1);

namespace Qiq\Helper;

class EscapeCss extends Helper
{
    public function __invoke(mixed $raw) : string
    {
        return $this->escape->c($raw);
    }
}
