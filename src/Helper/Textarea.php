<?php
namespace Qiq\Helper;

class Textarea extends Helper
{
    public function __invoke(array $attr) : string
    {
        $text = $attr['value'] ?? '';
        unset($attr['value']);
        return $this->fullTag('textarea', $attr, $text);
    }
}
