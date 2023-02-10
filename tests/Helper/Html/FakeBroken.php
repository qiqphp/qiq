<?php
namespace Qiq\Helper\Html;

use SplFileObject;
use stdClass;

class FakeBroken
{
    public function __construct(
        protected SplFileObject|stdClass $object
    ) {
    }
}
