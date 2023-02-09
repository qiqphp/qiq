<?php
declare(strict_types=1);

namespace Qiq\Helper;

class AnchorTest extends HelperTest
{
    public function test()
    {
        $actual = $this->helper('/path/to/script.php', 'this');
        $expect = '<a href="/path/to/script.php">this</a>';
        $this->assertSame($expect, $actual);

        $actual = $this->helper('/path/to/script.php', 'foo', ['bar' => 'baz', 'href' => 'skip-me']);
        $expect = '<a href="/path/to/script.php" bar="baz">foo</a>';
        $this->assertSame($expect, $actual);
    }
}
