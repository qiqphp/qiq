<?php
namespace Qiq\Helper;

class MetaHttp extends Helper
{
    public function __invoke(string $equiv, string $content) : string
    {
        return $this->voidTag('meta', [
            'http-equiv' => $equiv,
            'content' => $content,
        ]);
    }
}
