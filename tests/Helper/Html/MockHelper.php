<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class MockHelper
{
    public function __invoke($noun)
    {
        return "Hello $noun";
    }
}
