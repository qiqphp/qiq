<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

use Qiq\Indent;

class Items extends TagHelper
{
    /**
     * @param array<null|scalar|\Stringable> $items
     */
    public function __invoke(array $items) : string
    {
        return $this->items($items);
    }

    /**
     * @param array<null|scalar|\Stringable> $items
     */
    protected function items(array $items) : string
    {
        $html = '';

        foreach ($items as $item) {
            $html .= $this->indent->get() . $this->fullTag('li', [], $item) . PHP_EOL;
        }

        return $html;
    }
}
