<?php
namespace Qiq\Helper;

use Qiq\Indent;

class Dl extends Helper
{
    public function __invoke(array $terms, array $attr = []) : string
    {
        Indent::level(+1);
        $list = $this->terms($terms);
        Indent::level(-1);

        if ($list === '') {
            return '';
        }

        return $this->openTag('dl', $attr) . PHP_EOL
            . $list
            . Indent::get() . '</dl>';
    }

    protected function terms(array $terms) : string
    {
        $html = '';

        foreach ($terms as $term => $defs) {
            $html .= Indent::get() . $this->fullTag('dt', [], $term) . PHP_EOL;

            foreach ((array) $defs as $def) {
                $html .= Indent::get(+1) . $this->fullTag('dd', [], $def) . PHP_EOL;
            }
        }

        return $html;
    }
}
