<?php
declare(strict_types=1);

namespace Qiq;

use Qiq\Compiler\Compiler;

class TemplateLocator
{
    protected array $paths = [];

    protected array $found = [];

    protected array $compiled = [];

    public function __construct(
        array $paths,
        protected string $extension,
        protected Compiler $compiler
    ) {
        $this->setPaths($paths);
    }

    public function has(string $name) : bool
    {
        if (isset($this->found[$name])) {
            return true;
        }

        $key = $name;
        list($collection, $name) = $this->split($name);
        $name = str_replace('/', DIRECTORY_SEPARATOR, $name);

        foreach ($this->paths[$collection] as $path) {
            $file = $path . DIRECTORY_SEPARATOR . $name . $this->extension;
            if (is_readable($file)) {
                $this->found[$key] = $file;
                return true;
            }
        }

        return false;
    }

    public function get(string $name) : string
    {
        if ($this->has($name)) {
            return $this->compile($name);
        }

        list($collection, $name) = $this->split($name);

        throw new Exception\TemplateNotFound(
            PHP_EOL
            . "Template: $name" . PHP_EOL
            . "Extension: {$this->extension}" . PHP_EOL
            . "Collection: " . ($collection === '' ? '(default)' : $collection) . PHP_EOL
            . "Paths: " . print_r($this->paths[$collection], true)
        );
    }

    public function getPaths() : array
    {
        return $this->paths;
    }

    public function prependPath(string $path) : void
    {
        list($collection, $path) = $this->split($path);
        array_unshift($this->paths[$collection], $this->fixPath($path));
        $this->found = [];
        $this->compiled = [];
    }

    public function appendPath(string $path) : void
    {
        list($collection, $path) = $this->split($path);
        $this->paths[$collection][] = $this->fixPath($path);
        $this->found = [];
        $this->compiled = [];
    }

    public function setPaths(array $paths) : void
    {
        $this->paths = [];

        foreach ($paths as $path) {
            list($collection, $path) = $this->split($path);
            $this->paths[$collection][] = $this->fixPath($path);
        }

        $this->found = [];
        $this->compiled = [];
    }

    public function setExtension(string $extension) : void
    {
        $this->extension = $extension;
        $this->found = [];
    }

    public function clear() : void
    {
        $this->found = [];
        $this->compiled = [];
        $this->compiler->clear();
    }

    protected function compile(string $name) : string
    {
        if (! isset($this->compiled[$name])) {
            $this->compiled[$name] = ($this->compiler)(
                $this->found[$name]
            );
        }

        return $this->compiled[$name];
    }

    protected function fixPath(string $path) : string
    {
        $path = str_replace('/', DIRECTORY_SEPARATOR, $path);
        return rtrim($path, DIRECTORY_SEPARATOR);
    }

    protected function split(string $spec) : array
    {
        if (strpos($spec, '..') !== false) {
            throw new Exception\TemplateNotFound("Double-dots not allowed in template specifications: $spec");
        }

        $offset = (PHP_OS_FAMILY === 'Windows') ? 2 : 0;
        $pos = strpos($spec, ':', $offset);

        if (! $pos) {
            // not present, or at character zero
            $collection = '__DEFAULT__';
        } else {
            $collection = substr($spec, 0, $pos);
            $spec = substr($spec, $pos + 1);
        }

        if (! isset($this->paths[$collection])) {
            $this->paths[$collection] = [];
        }

        return [
            $collection,
            $spec
        ];
    }
}
