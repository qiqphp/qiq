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
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $__attr
     */
    protected function openTag(
        string $tag,
        array $attr,
        array $__attr = []
    ) : string
    {
        $tag = $this->escape->a($tag);
        $attr = $this->attr($attr, $__attr);
        return trim("<{$tag} {$attr}") . ">";
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $__attr
     * @param null|scalar|\Stringable $text
     */
    protected function fullTag(
        string $tag,
        array $attr,
        mixed $text = '',
        array $__attr = []
    ) : string
    {
        $text = $this->escape->h($text);
        return $this->openTag($tag, $attr, $__attr) . $text . "</{$tag}>";
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $__attr
     */
    protected function voidTag(
        string $tag,
        array $attr,
        array $__attr = []
    ) : string
    {
        $tag = $this->escape->a($tag);
        $attr = $this->attr($attr, $__attr);
        return trim("<{$tag} {$attr}") . " />";
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $__attr
     */
    protected function attr(array $attr, array $__attr) : string
    {
        foreach ($__attr as $key => $val) {
            unset($__attr[$key]);
            $key = str_replace('_', '-', $key);
            $__attr[$key] = $val;
        }

        return $this->escape->a(array_merge($attr, $__attr));
    }
}
