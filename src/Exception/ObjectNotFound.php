<?php
declare(strict_types=1);

namespace Qiq\Exception;

use Psr\Container\NotFoundExceptionInterface;
use Qiq\Exception;

class ObjectNotFound extends Exception implements NotFoundExceptionInterface
{
}
