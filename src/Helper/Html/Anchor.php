<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class Anchor extends TagHelper
{
    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function __invoke(
        string $href,
        string $text,
        array $attr = [],
        mixed ...$__attr
    ) : string
    {
        $base = [
            'id' => null,
            'href' => $href,
        ];

        unset($attr['href']);
        $attr = array_merge($base, $attr);

        return $this->fullTag('a', $attr, $text, $__attr);
    }
}
