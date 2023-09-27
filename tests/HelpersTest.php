<?php
namespace Qiq;

use Qiq\Exception;
use Qiq\Helper\Html\FakeBroken;
use Qiq\Helper\Html\FakeHello;

class HelpersTest extends \PHPUnit\Framework\TestCase
{
    public function test__call() : void
    {
        $helpers = new Helpers();
        $expect = 'FOOBAR';

        /** @phpstan-ignore-next-line checking function fallback for missing method */
        $actual = $helpers->strtoupper('foobar');
        $this->assertSame($expect, $actual);
    }
}
