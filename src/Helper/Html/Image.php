<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class Image extends TagHelper
{
    /**
     * @param stringy-attr $attr
     */
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
