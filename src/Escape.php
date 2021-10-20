<?php
namespace Qiq;

use Laminas\Escaper\Escaper;

class Escape
{
    protected Escaper $escaper;

    public function __construct(string $encoding = 'utf-8')
    {
        $this->escaper = new Escaper($encoding);
    }

    public function a(string|array $raw) : string
    {
        if (is_string($raw)) {
            return $this->escaper->escapeHtmlAttr($raw);
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
                      . $this->escaper->escapeHtml($val) . '"';
            }

            // space separator
            $esc .= ' ';
        }

        // done; remove the last space
        return rtrim($esc);
    }

    public function c(string $raw) : string
    {
        return $this->escaper->escapeCss($raw);
    }

    public function h(string $raw) : string
    {
        return $this->escaper->escapeHtml($raw);
    }

    public function j(string $raw) : string
    {
        return $this->escaper->escapeJs($raw);
    }

    public function u(string $raw) : string
    {
        return $this->escaper->escapeUrl($raw);
    }
}
