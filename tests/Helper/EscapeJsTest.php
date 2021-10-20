<?php
namespace Qiq\Helper;

class EscapeJsTest extends HelperTest
{
    public function test()
    {
        $chars = [
            /* HTML special chars - escape without exception to hex */
            '<'     => '\\x3C',
            '>'     => '\\x3E',
            '\''    => '\\x27',
            '"'     => '\\x22',
            '&'     => '\\x26',
            /* Characters beyond ASCII value 255 to unicode escape */
            'Ā'     => '\\u0100',
            /* Immune chars excluded */
            ','     => ',',
            '.'     => '.',
            '_'     => '_',
            /* Basic alnums exluded */
            'a'     => 'a',
            'A'     => 'A',
            'z'     => 'z',
            'Z'     => 'Z',
            '0'     => '0',
            '9'     => '9',
            /* Basic control characters and null */
            "\r"    => '\\x0D',
            "\n"    => '\\x0A',
            "\t"    => '\\x09',
            "\0"    => '\\x00',
            /* Encode spaces for quoteless attribute protection */
            ' '     => '\\x20',
        ];

        foreach ($chars as $key => $val) {
            $this->assertEquals(
                $val,
                $this->helper($key),
                'Failed to escape: ' . $key
            );
        }
    }
}
