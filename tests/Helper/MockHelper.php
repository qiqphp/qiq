<?php
namespace Qiq\Helper;

class MockHelper
{
    public function __invoke($noun)
    {
        return "Hello $noun";
    }
}
