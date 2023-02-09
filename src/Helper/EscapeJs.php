<?php
declare(strict_types=1);

namespace Qiq\Helper;

class EscapeJs extends Helper
{
    public function __invoke(mixed $raw) : string
    {
        return $this->escape->j($raw);
    }
}
