<?php
namespace Qiq\Helper;

use Qiq\Indent;

class Ol extends Items
{
    public function __invoke(array $items, array $attr = []) : string
    {
        Indent::level(+1);
        $list = $this->items($items);
        Indent::level(-1);

        if ($list === '') {
            return '';
        }

        return $this->openTag('ol', $attr) . PHP_EOL
            . $list
            . Indent::get() . '</ol>';
    }
}
