<?php
declare(strict_types=1);

namespace Qiq\Helper;

class LinkStylesheet extends Helper
{
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
