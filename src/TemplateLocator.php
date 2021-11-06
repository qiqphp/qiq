<?php
namespace Qiq;

use Qiq\Compiler\Compiler;
use Qiq\Compiler\QiqCompiler;
use Qiq\Fsio;

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

        foreach ($this->paths[$collection] as $path) {
            $file = Fsio::concat($path, "{$name}{$this->extension}");
            var_dump($file);
            if (Fsio::isReadable($file)) {
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

        list ($collection, $name) = $this->split($name);

        throw new Exception\TemplateNotFound(PHP_EOL
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
        list ($collection, $path) = $this->split($path);
        array_unshift($this->paths[$collection], Fsio::rtrim($path));
        $this->found = [];
        $this->compiled = [];
    }

    public function appendPath(string $path) : void
    {
        list ($collection, $path) = $this->split($path);
        $this->paths[$collection][] = Fsio::rtrim($path);
        $this->found = [];
        $this->compiled = [];
    }

    public function setPaths(array $paths) : void
    {
        $this->paths = [];

        foreach ($paths as $path) {
            list ($collection, $path) = $this->split($path);
            $this->paths[$collection][] = Fsio::rtrim($path);
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

    protected function split(string $spec) : array
    {
        $offset = (DIRECTORY_SEPARATOR === '\\') ? 2 : 0;

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
