<?php
declare(strict_types=1);

namespace Qiq\Helper;

use Laminas\Escaper\Escaper;

class Escape
{
    protected Escaper $escaper;

    public function __construct(mixed $encoding = 'utf-8')
    {
        $this->escaper = new Escaper($encoding);
    }

    public function a(mixed $raw) : string
    {
        if (! is_array($raw)) {
            return $this->escaper->escapeHtmlAttr((string) $raw);
        }

        $esc = '';
        foreach ($raw as $key => $val) {

            // do not add null and false values
            if ($val === null || $val === false) {
                continue;
            }

            // get rid of extra spaces in the key
            $key = trim($key);

            // concatenate and space-separate multiple values
            if (is_array($val)) {
                $val = implode(' ', $val);
            }

            // what kind of attribute representation?
            if ($val === true) {
                // minimized
                $esc .= $this->escaper->escapeHtmlAttr($key);
            } else {
                // full; because the it is quoted, we can use html ecaping
                $esc .= $this->escaper->escapeHtmlAttr($key) . '="'
                      . $this->escaper->escapeHtml((string) $val) . '"';
            }

            // space separator
            $esc .= ' ';
        }

        // done; remove the last space
        return rtrim($esc);
    }

    public function c(mixed $raw) : string
    {
        return $this->escaper->escapeCss((string) $raw);
    }

    public function h(mixed $raw) : string
    {
        return $this->escaper->escapeHtml((string) $raw);
    }

    public function j(mixed $raw) : string
    {
        return $this->escaper->escapeJs((string) $raw);
    }

    public function u(mixed $raw) : string
    {
        return $this->escaper->escapeUrl((string) $raw);
    }
}
