<?php
namespace Qiq;

use Qiq\Exception;
use Qiq\Helper\Html\FakeBroken;
use Qiq\Helper\Html\FakeHello;

class ContainerTest extends \PHPUnit\Framework\TestCase
{
    public function test() : void
    {
        $container = new Container();
        $expect = FakeHello::class;
        $actual = $container->get(FakeHello::class);
        $this->assertInstanceOf($expect, $actual);
        $this->assertSame("Hello World", $actual("World"));

        /** @phpstan-ignore-next-line */
        $this->assertFalse($container->has(NoSuchClass::class));
        $this->expectException(Exception\ObjectNotFound::class);

        /** @phpstan-ignore-next-line */
        $container->get(NoSuchHelper::class);
    }

    public function testConfig() : void
    {
        $container = new Container([FakeHello::class => ['suffix' => ' !!!']]);
        $actual = $container->get(FakeHello::class);
        $this->assertSame("Hello World !!!", $actual("World"));
    }

    public function testCannotInstantiate() : void
    {
        $container = new Container();
        $this->expectException(Exception\ParameterNotResolved::class);
        $this->expectExceptionMessage(
            "Cannot create argument for 'Qiq\Helper\Html\FakeBroken::\$object' of type 'SplFileObject|stdClass",
        );
        $container->get(FakeBroken::class);
    }
}
