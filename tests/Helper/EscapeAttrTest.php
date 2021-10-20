<?php
namespace Qiq\Helper;

class EscapeAttrTest extends HelperTest
{
    public function test()
    {
        $chars = [
            '\''    => '&#x27;',
            '"'     => '&quot;',
            '<'     => '&lt;',
            '>'     => '&gt;',
            '&'     => '&amp;',
            /* Characters beyond ASCII value 255 to unicode escape */
            'Ā'     => '&#x0100;',
            /* Immune chars excluded */
            ','     => ',',
            '.'     => '.',
            '-'     => '-',
            '_'     => '_',
            /* Basic alnums exluded */
            'a'     => 'a',
            'A'     => 'A',
            'z'     => 'z',
            'Z'     => 'Z',
            '0'     => '0',
            '9'     => '9',
            /* Basic control characters and null */
            "\r"    => '&#x0D;',
            "\n"    => '&#x0A;',
            "\t"    => '&#x09;',
            "\0"    => '&#xFFFD;', // should use Unicode replacement char
            /* Encode chars as named entities where possible */
            '<'     => '&lt;',
            '>'     => '&gt;',
            '&'     => '&amp;',
            '"'     => '&quot;',
            /* Encode spaces for quoteless attribute protection */
            ' '     => '&#x20;',
        ];

        foreach ($chars as $key => $val) {
            $this->assertEquals(
                $val,
                $this->helper($key),
                'Failed to escape: ' . $key
            );
        }

        $expect = 'foo="bar baz dib"';
        $actual = $this->helper([
            'foo' => [
                'bar',
                'baz',
                'dib',
            ]
        ]);
        $this->assertSame($expect, $actual);
    }
}
