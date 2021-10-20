<?php
namespace Qiq\Helper;

use Qiq\Indent;

class Items extends Helper
{
    public function __invoke(array $items) : string
    {
        return $this->items($items);
    }

    protected function items(array $items) : string
    {
        $html = '';

        foreach ($items as $item) {
            $html .= Indent::get() . $this->fullTag('li', [], $item) . PHP_EOL;
        }

        return $html;
    }
}
