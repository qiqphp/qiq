<?php
declare(strict_types=1);

namespace Qiq\Helper;

class EscapeHtmlTest extends HelperTest
{
    public function test()
    {
        $chars = [
            '\''    => '&#039;',
            '"'     => '&quot;',
            '<'     => '&lt;',
            '>'     => '&gt;',
            '&'     => '&amp;'
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
