<?php
declare(strict_types=1);

namespace Qiq\Helper;

class Label extends Helper
{
    public function __invoke(string $text, array $attr = []) : string
    {
        return $this->fullTag('label', $attr, $text);
    }
}
