<?php
namespace Qiq\Helper;

use Qiq\Escape;
use Qiq\Indent;

abstract class HelperTest extends \PHPUnit\Framework\TestCase
{
    protected $helper;

    protected function setUp() : void
    {
        parent::setUp();
        Indent::set('');
        $this->helper = $this->newHelper();
    }

    protected function newHelper()
    {
        $class = substr(get_class($this), 0, -4);
        return new $class(new Escape());
    }

    protected function helper(...$args)
    {
        return ($this->helper)(...$args);
    }
}
