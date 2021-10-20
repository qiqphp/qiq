<?php
namespace Qiq\Helper;

class Image extends Helper
{
    public function __invoke(string $src, array $attr = []) : string
    {
        $base = [
            'src' => $src,
            'alt' => basename($src),
        ];

        unset($attr['src']);
        $attr = array_merge($base, $attr);
        return $this->voidTag('img', $attr);
    }
}
