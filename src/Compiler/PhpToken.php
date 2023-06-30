<?php
declare(strict_types=1);

namespace Qiq\Compiler;

class PhpToken extends \PhpToken
{
    public function isSignificant() : bool
    {
        return ! $this->is([
            T_WHITESPACE,
            T_COMMENT,
            T_DOC_COMMENT,
        ]);
    }
}
