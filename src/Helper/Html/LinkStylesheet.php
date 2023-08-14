<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class LinkStylesheet extends TagHelper
{
    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function __invoke(string $href, array $attr = [], mixed ...$__attr) : string
    {
        $base = [
            'id' => null,
            'rel' => 'stylesheet',
            'href' => $href,
            'type' => 'text/css',
            'media' => 'screen',
        ];
        unset($attr['rel']);
        unset($attr['href']);
        $attr = array_merge($base, $attr);
        return $this->voidTag('link', $attr, $__attr);
    }
}
