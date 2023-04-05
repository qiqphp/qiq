<?php
declare(strict_types=1);

namespace Qiq;

use Psr\Container\ContainerInterface;

class Helpers
{
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container ?? new Container();
    }

    public function __call(string $func, array $args) : mixed
    {
        return $func(...$args);
    }

    /**
     * @template T of object
     * @param class-string<T> $class
     * @return T of object
     */
    protected function get(string $class) : object
    {
        /** @var T of object */
        return $this->container->get($class);
    }

    public function setIndent(string $base) : void
    {
        $this->get(Indent::class)->set($base);
    }
}
