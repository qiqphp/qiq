<?php
declare(strict_types=1);

namespace Qiq\Helper;

class MetaName extends TagHelper
{
    public function __invoke(string $name, string $content) : string
    {
        return $this->voidTag('meta', [
            'name' => $name,
            'content' => $content,
        ]);
    }
}
