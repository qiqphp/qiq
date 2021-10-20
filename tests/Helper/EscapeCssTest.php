<?php
namespace Qiq\Helper;

class EscapeCssTest extends HelperTest
{
    public function test()
    {
        $chars = [
            /* HTML special chars - escape without exception to hex */
            '<'     => '\\3C ',
            '>'     => '\\3E ',
            '\''    => '\\27 ',
            '"'     => '\\22 ',
            '&'     => '\\26 ',
            /* Characters beyond ASCII value 255 to unicode escape */
            'Ā'     => '\\100 ',
            /* Immune chars excluded */
            ','     => '\\2C ',
            '.'     => '\\2E ',
            '_'     => '\\5F ',
            /* Basic alnums exluded */
            'a'     => 'a',
            'A'     => 'A',
            'z'     => 'z',
            'Z'     => 'Z',
            '0'     => '0',
            '9'     => '9',
            /* Basic control characters and null */
            "\r"    => '\\D ',
            "\n"    => '\\A ',
            "\t"    => '\\9 ',
            "\0"    => '\\0 ',
            /* Encode spaces for quoteless attribute protection */
            ' '     => '\\20 ',
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
