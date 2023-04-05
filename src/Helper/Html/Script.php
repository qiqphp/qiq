<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class Script extends TagHelper
{
    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function __invoke(
        string $src,
        array $attr = [],
        mixed ...$__attr
    ) : string
    {
        $base = [
            'id' => null,
            'src' => $src,
            'type' => 'text/javascript'
        ];
        unset($attr['src']);
        $attr = array_merge($base, $attr);
        return $this->fullTag('script', $attr, '', $__attr);
    }
}
