<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class Textarea extends TagHelper
{
    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function __invoke(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr
    ) : string
    {
        $attr = array_merge(['name' => $name], $attr);
        return $this->fullTag('textarea', $attr, $value, $__attr);
    }
}
