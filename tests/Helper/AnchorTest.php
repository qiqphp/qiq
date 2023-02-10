<?php
namespace Qiq\Helper;

class AnchorTest extends HtmlHelperTest
{
    public function test() : void
    {
        $actual = $this->helpers->anchor('/path/to/script.php', 'this');
        $expect = '<a href="/path/to/script.php">this</a>';
        $this->assertSame($expect, $actual);

        $actual = $this->helpers->anchor('/path/to/script.php', 'foo', ['bar' => 'baz', 'href' => 'skip-me']);
        $expect = '<a href="/path/to/script.php" bar="baz">foo</a>';
        $this->assertSame($expect, $actual);
    }
}
