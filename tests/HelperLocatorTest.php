<?php
declare(strict_types=1);

namespace Qiq;

class HelperLocatorTest extends \PHPUnit\Framework\TestCase
{
    protected $helperLocator;

    protected function setUp() : void
    {
        $this->helperLocator = HelperLocator::new();
    }

    public function test()
    {
        $this->helperLocator->set('mockHelper', function () {
            return new Helper\MockHelper();
        });

        $expect = Helper\MockHelper::CLASS;
        $actual = $this->helperLocator->get('mockHelper');
        $this->assertInstanceOf($expect, $actual);

        $expect = 'Hello World';
        $actual = $this->helperLocator->mockHelper('World');
        $this->assertSame($expect, $actual);

        $this->expectException(Exception\HelperNotFound::CLASS);
        $this->helperLocator->get('noSuchHelper');
    }

    public function testFunction()
    {
        $expect = 'foo';
        $actual = $this->helperLocator->trim('  foo  ');
        $this->assertSame($expect, $actual);
    }

    public function testAddingNewHelperFactories()
    {
        $factories = [
            'mockHelper' => function () {
                return new Helper\MockHelper();
            }
        ];

        $helperLocator = HelperLocator::new(factories: $factories);

        $expect = Helper\MockHelper::CLASS;
        $actual = $helperLocator->get('mockHelper');
        $this->assertInstanceOf($expect, $actual);

        $expect = 'Hello World';
        $actual = $helperLocator->mockHelper('World');
        $this->assertSame($expect, $actual);

        $this->expectException(Exception\HelperNotFound::CLASS);
        $helperLocator->get('noSuchHelper');
    }

    public function testOverrideDefaultHelperFactories()
    {
        $factories = [
            'a' => function () {
                return new Helper\MockHelper();
            }
        ];

        $helperLocator = HelperLocator::new(factories: $factories);

        $expect = Helper\MockHelper::CLASS;
        $actual = $helperLocator->get('a');
        $this->assertInstanceOf($expect, $actual);

        $expect = 'Hello World';
        $actual = $helperLocator->a('World');
        $this->assertSame($expect, $actual);
    }
}
