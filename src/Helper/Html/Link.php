<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class Link extends TagHelper
{
    public function __invoke(string $rel, string $href, array $attr = []) : string
    {
        $base = [
            'rel' => $rel,
            'href' => $href,
        ];

        unset($attr['rel']);
        unset($attr['href']);

        $attr = array_merge($base, $attr);
        return $this->voidTag('link', $attr);
    }
}
