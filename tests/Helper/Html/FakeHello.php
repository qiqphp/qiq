<?php
namespace Qiq\Helper\Html;

use SplFileObject;
use stdClass;

class FakeHello
{
    public function __construct(
        protected string $suffix = '',
        protected null|SplFileObject|stdClass $object = null
    ) {
    }

    public function __invoke(string $noun) : string
    {
        return "Hello {$noun}" . $this->suffix;
    }
}
