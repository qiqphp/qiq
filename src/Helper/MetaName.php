<?php
namespace Qiq\Helper;

class MetaName extends Helper
{
    public function __invoke(string $name, string $content) : string
    {
        return $this->voidTag('meta', [
            'name' => $name,
            'content' => $content,
        ]);
    }
}
