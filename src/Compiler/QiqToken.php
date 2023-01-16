<?php
namespace Qiq\Compiler;

class QiqToken
{
    protected const INDENT = [
        "\n" => '\n',
        "\r" => '\r',
        "\t" => '\t',
    ];

    protected const KNOWN = [
        '__DIR__',
        '__FILE__',
        '__LINE__',
        'break',
        'continue',
        'declare',
        'else',
        'elseif',
        'empty',
        'endfor',
        'endforeach',
        'endif',
        'endwhile',
        'for',
        'foreach',
        'goto',
        'if',
        'include',
        'include_once',
        'isset',
        'list',
        'namespace',
        'require',
        'require_once',
        'use',
        'while',
    ];

    static public function new(string $part) : ?self
    {
        $result = preg_match(
            '/(\s*){{(\s*)([a-z=~]\s+|\s*)(\W|\w+)(.*?)(\s*)}}(\s*)/msi',
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
            tailingSpaceOuter: $matches[7] ?? '',
        );
    }

    protected string $closing = '';

    public function __construct(
        protected string $leadingSpaceOuter,
        protected string $leadingSpaceInner,
        protected string $opening,
        protected string $firstWord,
        protected string $remainder,
        protected string $tailingSpaceInner,
        protected string $tailingSpaceOuter,
    ) {
        $this->fixEcho();
    }

    public function __toString()
    {
        $code = $this->firstWord . $this->remainder;
        $char = substr($this->firstWord, 0, 1);
        $indent = '';

        if (
            (ctype_alpha($char) || $char === '_')
            && ! defined($this->firstWord)
            && ! in_array($this->firstWord, static::KNOWN)
        ) {
            // alphabetic or underscore, but not defined and not known.
            // treat as a helper. set indent so helper can use it if needed.
            $code = "\$this->{$code}";
            $indent = $this->indent($this->leadingSpaceOuter);
        }

        return $this->leadingSpaceOuter
            . $indent
            . $this->opening
            . $code
            . $this->closing
            . $this->tailingSpaceOuter;
    }

    protected function indent(string $space) : string
    {
        $space = strrchr($space, PHP_EOL);

        if ($space === false) {
            return '';
        }

        $space = strtr($space, self::INDENT);
        return "<?php \\Qiq\\Indent::set(\"$space\") ?>";
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
}
