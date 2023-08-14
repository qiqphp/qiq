<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class Image extends TagHelper
{
    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function __invoke(string $src, array $attr = [], mixed ...$__attr) : string
    {
        $base = ['id' => null, 'src' => $src, 'alt' => basename($src)];
        unset($attr['src']);
        $attr = array_merge($base, $attr);
        return $this->voidTag('img', $attr, $__attr);
    }
}
