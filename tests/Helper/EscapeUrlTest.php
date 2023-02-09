<?php
declare(strict_types=1);

namespace Qiq\Helper;

class EscapeUrlTest extends HelperTest
{
    public function test()
    {
        $this->assertSame(
            'http%3A%2F%2Fuser%3Apass%40example.net%2Fpath%2F%3Fqstr%23hash',
            $this->helper('http://user:pass@example.net/path/?qstr#hash')
        );
    }
}
