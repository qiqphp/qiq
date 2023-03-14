<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class Textarea extends TagHelper
{
    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function __invoke(array $attr) : string
    {
        $text = $attr['value'] ?? '';
        settype($text, 'string');
        assert(is_string($text));
        unset($attr['value']);
        return $this->fullTag('textarea', $attr, $text);
    }
}
