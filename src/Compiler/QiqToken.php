<?php
declare(strict_types=1);

namespace Qiq\Compiler;

use PhpToken;

class QiqToken
{
    protected const INDENT = [
        "\n" => '\n',
        "\r" => '\r',
        "\t" => '\t',
    ];

    public static function new(string $part) : ?self
    {
        $result = preg_match(
            '/(\s*){{(\s*)([a-z=~]\s+|\s*)(\W|\w+)(.*?)(\s*)(~\s*)?}}(\s*)/msi',
            $part,
            $matches,
        );

        if ($result === false || empty($matches)) {
            return null;
        }

        return new self(
            leadingSpaceOuter: $matches[1] ?? '',
            leadingSpaceInner: $matches[2] ?? '',
            opening: $matches[3] ?? '',
            firstWord: $matches[4] ?? '',
            remainder: $matches[5] ?? '',
            tailingSpaceInner: empty($matches[6]) ? ' ' : $matches[6],
            tailingTagChar: empty($matches[7]) ? '' : trim($matches[7]),
            tailingSpaceOuter: $matches[8] ?? '',
        );
    }

    protected string $closing = '';

    /**
     * @var PhpToken[]
     */
    protected array $tokens = [];

    protected int $tokensCount = 0;

    public function __construct(
        protected string $leadingSpaceOuter,
        protected string $leadingSpaceInner,
        protected string $opening,
        protected string $firstWord,
        protected string $remainder,
        protected string $tailingSpaceInner,
        protected string $tailingSpaceOuter,
        protected string $tailingTagChar = '',
    ) {
        $this->fixEcho();
    }

    public function __toString()
    {
        return $this->leadingSpaceOuter
            . $this->indent($this->leadingSpaceOuter)
            . $this->code()
            . $this->tailingSpaceOuter;
    }

    protected function indent(string $space) : string
    {
        $space = strrchr($space, PHP_EOL);

        if ($space === false) {
            return '';
        }

        $space = strtr($space, self::INDENT);
        return "<?php \$this->setIndent(\"$space\") ?>";
    }

    protected function fixEcho() : void
    {
        if ($this->opening === '' || ctype_space($this->opening)) {
            $this->fixEchoNone();
            return;
        }

        $char = substr($this->opening, 0, 1);

        switch ($char) {
            case '~':
                $this->fixEchoPreline();
                return;
            case '=':
                $this->fixEchoRaw();
                return;
            default:
                $this->fixEchoEscaped($char);
                return;
        }
    }

    protected function fixEchoNone() : void
    {
        $space = $this->leadingSpaceInner . $this->opening;

        if ($space === '') {
            $space = ' ';
        }

        $this->opening = '<?php'. $space;
        $this->closing = $this->tailingSpaceInner . '?>';
    }

    protected function fixEchoPreline() : void
    {
        $this->opening = substr($this->opening, 1);
        $this->fixEchoNone();
        $this->opening = '<?= PHP_EOL ?>' . $this->opening;
    }

    protected function fixEchoRaw() : void
    {
        $space = $this->leadingSpaceInner
            . $this->lclip(substr($this->opening, 1));

        if ($space === '') {
            $space = ' ';
        }

        $this->opening = '<?=' . $space;
        $this->closing = $this->tailingSpaceInner . '?>';
        $this->fixEchoAddline();
    }

    protected function fixEchoEscaped(string $char) : void
    {
        $space = $this->lclip(substr($this->opening, 1));
        $inner = $this->leadingSpaceInner;

        if ($inner === '') {
            $inner = ' ';
        }

        $this->opening = '<?=' . $inner . '$this->' . $char . '(' . $space;

        if (strpos($this->tailingSpaceInner, PHP_EOL) === false) {
            $this->closing = $this->clip($this->tailingSpaceInner);
        } else {
            $this->closing = $this->tailingSpaceInner;
        }

        $this->closing .= ') ?>';
        $this->fixEchoAddline();
    }

    protected function fixEchoAddline() : void
    {
        if (
            substr($this->tailingSpaceOuter, 0, strlen(PHP_EOL)) === PHP_EOL
            && $this->tailingTagChar !== '~'
        ) {
            $this->closing .= '<?= PHP_EOL ?>';
        }
    }

    protected function clip(string $str) : string
    {
        return trim($str, "\t ");
    }

    protected function lclip(string $str) : string
    {
        return ltrim($str, "\t ");
    }

    protected function code(): string
    {
        if ($this->firstWord === 'extends') {
            // subvert the tokenizer process, because 'extends' is a PHP keyword
            $this->firstWord = '$this->extends';
        }

        $this->tokens = PhpToken::tokenize(
            $this->opening
            . $this->firstWord
            . $this->remainder
            . $this->closing
        );

        $this->tokensCount = count($this->tokens);

        $code = '';

        foreach ($this->tokens as $i => $token) {
            if ($this->isFunctionCall($i)) {
                $code .= '$this->';
            }

            $code .= $token->text;
        }

        return $code;
    }

    protected function isFunctionCall(int $i): bool
    {
        $curr = $this->tokens[$i];

        if (! $curr->is(T_STRING)) {
            return false;
        }

        $next = $this->nextToken($i);

        if (! $next?->is('(')) {
            return false;
        }

        $prev = $this->prevToken($i);

        if ($prev?->is([
            T_OBJECT_OPERATOR,
            T_NULLSAFE_OBJECT_OPERATOR,
            T_DOUBLE_COLON,
            T_FUNCTION,
        ])) {
            return false;
        }

        return true;
    }

    protected function prevToken(int $i): ?PhpToken
    {
        while ($i > 0) {
            $i --;

            if (! $this->tokens[$i]->is(T_WHITESPACE)) {
                return $this->tokens[$i];
            }
        }

        return null;
    }

    protected function nextToken(int $i): ?PhpToken
    {
        while ($i < $this->tokensCount) {
            $i ++;

            if (! $this->tokens[$i]->is(T_WHITESPACE)) {
                return $this->tokens[$i];
            }
        }

        return null;
    }
}
