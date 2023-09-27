<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class EscapeTest extends HtmlHelperTestCase
{
    public function testAttr_string() : void
    {
        $chars = [
            '\'' => '&#x27;',
            '"' => '&quot;',
            '<' => '&lt;',
            '>' => '&gt;',
            '&' => '&amp;',

            /* Characters beyond ASCII value 255 to unicode escape */
            'Ā' => '&#x0100;',

            /* Immune chars excluded */
            ',' => ',',
            '.' => '.',
            '-' => '-',
            '_' => '_',

            /* Basic alnums exluded */
            'a' => 'a',
            'A' => 'A',
            'z' => 'z',
            'Z' => 'Z',
            '0' => '0',
            '9' => '9',

            /* Basic control characters */
            "\r" => '&#x0D;',
            "\n" => '&#x0A;',
            "\t" => '&#x09;',

            // null should use Unicode replacement char
            "\0" => '&#xFFFD;',

            /* Encode spaces for quoteless attribute protection */
            ' ' => '&#x20;',
        ];

        foreach ($chars as $key => $val) {
            $this->assertEquals(
                $val,
                $this->helpers->a($key),
                'Failed to escape: ' . $key,
            );
        }

        $expect = 'foo="bar baz dib"';
        $actual = $this->helpers->a(['foo' => ['bar', 'baz', 'dib']]);
        $this->assertSame($expect, $actual);
    }

    public function testCss() : void
    {
        $chars = [
            /* HTML special chars - escape without exception to hex */
            '<' => '\\3C ',
            '>' => '\\3E ',
            '\'' => '\\27 ',
            '"' => '\\22 ',
            '&' => '\\26 ',

            /* Characters beyond ASCII value 255 to unicode escape */
            'Ā' => '\\100 ',

            /* Immune chars excluded */
            ',' => '\\2C ',
            '.' => '\\2E ',
            '_' => '\\5F ',

            /* Basic alnums exluded */
            'a' => 'a',
            'A' => 'A',
            'z' => 'z',
            'Z' => 'Z',
            '0' => '0',
            '9' => '9',

            /* Basic control characters and null */
            "\r" => '\\D ',
            "\n" => '\\A ',
            "\t" => '\\9 ',
            "\0" => '\\0 ',

            /* Encode spaces for quoteless attribute protection */
            ' ' => '\\20 ',
        ];

        foreach ($chars as $key => $val) {
            $this->assertEquals(
                $val,
                $this->helpers->c($key),
                'Failed to escape: ' . $key,
            );
        }
    }

    public function testHtml() : void
    {
        $chars = [
            '\'' => '&#039;',
            '"' => '&quot;',
            '<' => '&lt;',
            '>' => '&gt;',
            '&' => '&amp;',
        ];

        foreach ($chars as $key => $val) {
            $this->assertEquals(
                $val,
                $this->helpers->h($key),
                'Failed to escape: ' . $key,
            );
        }
    }

    public function testJs() : void
    {
        $chars = [
            /* HTML special chars - escape without exception to hex */
            '<' => '\\x3C',
            '>' => '\\x3E',
            '\'' => '\\x27',
            '"' => '\\x22',
            '&' => '\\x26',

            /* Characters beyond ASCII value 255 to unicode escape */
            'Ā' => '\\u0100',

            /* Immune chars excluded */
            ',' => ',',
            '.' => '.',
            '_' => '_',

            /* Basic alnums exluded */
            'a' => 'a',
            'A' => 'A',
            'z' => 'z',
            'Z' => 'Z',
            '0' => '0',
            '9' => '9',

            /* Basic control characters and null */
            "\r" => '\\x0D',
            "\n" => '\\x0A',
            "\t" => '\\x09',
            "\0" => '\\x00',

            /* Encode spaces for quoteless attribute protection */
            ' ' => '\\x20',
        ];

        foreach ($chars as $key => $val) {
            $this->assertEquals(
                $val,
                $this->helpers->j($key),
                'Failed to escape: ' . $key,
            );
        }
    }

    public function testUrl() : void
    {
        $this->assertSame(
            'http%3A%2F%2Fuser%3Apass%40example.net%2Fpath%2F%3Fqstr%23hash',
            $this->helpers->u('http://user:pass@example.net/path/?qstr#hash'),
        );
    }
}
