<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class MetaHttp extends TagHelper
{
    public function __invoke(string $equiv, string $content) : string
    {
        return $this->voidTag('meta', [
            'http-equiv' => $equiv,
            'content' => $content,
        ]);
    }
}
