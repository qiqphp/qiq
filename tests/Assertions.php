<?php
declare(strict_types=1);

namespace Qiq;

trait Assertions
{
    public function assertSameString(string $expect, string $actual) : void
    {
        $expect = str_replace("\r\n", "\n", $expect);
        $actual = str_replace("\r\n", "\n", $actual);
        $this->assertSame($expect, $actual);
    }
}
