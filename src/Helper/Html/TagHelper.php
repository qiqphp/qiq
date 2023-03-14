<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

use Qiq\Indent;

abstract class TagHelper
{
    public function __construct(
        protected Escape $escape,
        protected Indent $indent,
    ) {
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    protected function openTag(string $tag, array $attr) : string
    {
        $tag = $this->escape->a($tag);
        $attr = $this->escape->a($attr);
        return trim("<{$tag} {$attr}") . ">";
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable $text
     */
    protected function fullTag(string $tag, array $attr, mixed $text = '') : string
    {
        $raw = $attr['_raw'] ?? false;
        unset($attr['_raw']);

        if (! $raw) {
            $text = $this->escape->h($text);
        }

        return $this->openTag($tag, $attr) . $text . "</{$tag}>";
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    protected function voidTag(string $tag, array $attr) : string
    {
        $tag = $this->escape->a($tag);
        $attr = $this->escape->a($attr);
        return trim("<{$tag} {$attr}") . " />";
    }
}
