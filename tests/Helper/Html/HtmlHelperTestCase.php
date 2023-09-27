<?php
namespace Qiq\Helper\Html;

use Qiq\Assertions;
use Qiq\Container;
use Qiq\Indent;

abstract class HtmlHelperTestCase extends \PHPUnit\Framework\TestCase
{
    use Assertions;

    protected HtmlHelpers $helpers;

    protected Container $container;

    protected function setUp() : void
    {
        parent::setUp();
        $this->container = new Container();
        $this->container->get(Indent::class)->set('');
        $this->helpers = $this->container->get(HtmlHelpers::class);
    }
}
