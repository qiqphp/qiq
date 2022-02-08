<?php
namespace Qiq;

class HelperLocator
{
    static public function new(Escape $escape = null): self
    {
        $escape ??= new Escape('utf-8');

        return new static([
            'a'      => static fn () => new Helper\EscapeAttr($escape),
            'c'      => static fn () => new Helper\EscapeCss($escape),
            'escape' => static fn () => $escape,
            'h'      => static fn () => new Helper\EscapeHtml($escape),
            'u'      => static fn () => new Helper\EscapeUrl($escape),
        ], $escape);
    }

    protected array $factories = [];
    protected array $instances = [];
    protected Escape $escape;

    public function __construct(array $factories, ?Escape $escape = null)
    {
        $this->factories = $factories;
        $this->escape  = $escape ?: new Escape('utf-8');
    }

    public function __call(string $name, array $args) : mixed
    {
        return $this->get($name)(...$args);
    }

    public function set(string $name, mixed /* callable */ $callable) : void
    {
        $this->factories[$name] = $callable;
        unset($this->instances[$name]);
    }

    public function has(string $name) : bool
    {
        if (isset($this->factories[$name]) || isset($this->instances[$name])) {
            return true;
        }

        $func = '\\' . $name;

        if (function_exists($name)) {
            $this->instances[$name] = $func;

            return true;
        }

        $mabeyHelper = 'Qiq\Helper\\' . $name;
        if (class_exists($mabeyHelper)) {
            if (! isset($this->factories[$name])) {
                $this->factories[$name] = fn () => new $mabeyHelper($this->escape);
            }

            return true;
        }

        return false;
    }

    public function get(string $name) : mixed
    {
        if (! $this->has($name)) {
            throw new Exception\HelperNotFound($name);
        }

        if (! isset($this->instances[$name])) {
            $factory = $this->factories[$name];
            $this->instances[$name] = $factory();
        }

        return $this->instances[$name];
    }
}