<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class LinkStylesheet extends TagHelper
{
    /**
     * @param stringy-attr $attr
     */
    public function __invoke(string $href, array $attr = []) : string
    {
        $base = [
            'rel' => 'stylesheet',
            'href' => $href,
            'type' => 'text/css',
            'media' => 'screen',
        ];

        unset($attr['rel']);
        unset($attr['href']);

        $attr = array_merge($base, $attr);
        return $this->voidTag('link', $attr);
    }
}
