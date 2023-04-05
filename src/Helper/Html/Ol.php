<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class Ol extends Items
{
    /**
     * @param array<null|scalar|\Stringable> $items
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function __invoke(
        array $items,
        array $attr = [],
        mixed ...$__attr
    ) : string
    {
        $this->indent->level(+1);
        $list = $this->items($items);
        $this->indent->level(-1);

        if ($list === '') {
            return '';
        }

        $attr = array_merge(['id' => null], $attr);

        return $this->openTag('ol', $attr, $__attr) . PHP_EOL
            . $list
            . $this->indent->get() . '</ol>';
    }
}
