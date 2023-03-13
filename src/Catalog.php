<?php
declare(strict_types=1);

namespace Qiq;

use FilesystemIterator;
use Qiq\Compiler;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class Catalog
{
    /**
     * @var array<string, string[]>
     */
    protected array $paths = [];

    /**
     * @var string[]
     */
    protected array $source = [];

    /**
     * @var string[]
     */
    protected array $compiled = [];

    /**
     * @param string[] $paths
     */
    public function __construct(
        array $paths,
        protected string $extension,
        protected Compiler $compiler
    ) {
        $this->setPaths($paths);
    }

    public function has(string $name) : bool
    {
        return $this->source($name) !== null;
    }

    protected function source(string $name) : ?string
    {
        if (isset($this->source[$name])) {
            return $this->source[$name];
        }

        $key = $name;
        list($collection, $name) = $this->split($name);
        $name = str_replace('/', DIRECTORY_SEPARATOR, $name);

        foreach ($this->paths[$collection] as $path) {
            $file = $path . DIRECTORY_SEPARATOR . $name . $this->extension;
            if (is_readable($file)) {
                $this->source[$key] = $file;
                return $file;
            }
        }

        return null;
    }

    public function getCompiled(string $name) : string
    {
        if (isset($this->compiled[$name])) {
            return $this->compiled[$name];
        }

        $source = $this->source($name);

        if ($source === null) {
            list($collection, $name) = $this->split($name);

            throw new Exception\FileNotFound(
                PHP_EOL
                . "Template: $name" . PHP_EOL
                . "Extension: {$this->extension}" . PHP_EOL
                . "Collection: " . ($collection === '' ? '(default)' : $collection) . PHP_EOL
                . "Paths: " . print_r($this->paths[$collection], true)
            );
        }

        $this->compiled[$name] = $this->compiler->compile($source);
        return $this->compiled[$name];
    }

    /**
     * @return array<string, string[]>
     */
    public function getPaths() : array
    {
        return $this->paths;
    }

    public function prependPath(string $path) : void
    {
        list($collection, $path) = $this->split($path);
        array_unshift($this->paths[$collection], $this->fixPath($path));
        $this->source = [];
        $this->compiled = [];
    }

    public function appendPath(string $path) : void
    {
        list($collection, $path) = $this->split($path);
        $this->paths[$collection][] = $this->fixPath($path);
        $this->source = [];
        $this->compiled = [];
    }

    /**
     * @param string[] $paths
     */
    public function setPaths(array $paths) : void
    {
        $this->paths = [];

        foreach ($paths as $path) {
            list($collection, $path) = $this->split($path);
            $this->paths[$collection][] = $this->fixPath($path);
        }

        $this->source = [];
        $this->compiled = [];
    }

    public function setExtension(string $extension) : void
    {
        $this->extension = $extension;
        $this->source = [];
        $this->compiled = [];
    }

    /**
     * @return string[]
     */
    public function compileAll() : array
    {
        $this->source = [];
        $this->compiled = [];

        $compiled = [];

        foreach ($this->paths as $collection => $paths) {
            foreach ($paths as $path) {
                $files = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator(
                        $path,
                        FilesystemIterator::SKIP_DOTS
                    ),
                    RecursiveIteratorIterator::CHILD_FIRST
                );

                /** @var SplFileInfo $file */
                foreach ($files as $file) {
                    $source = $file->getPathname();
                    if (str_ends_with($source, $this->extension)) {
                        $compiled[] = $this->compiler->compile($source);
                    }
                }
            }
        }

        return $compiled;
    }

    protected function fixPath(string $path) : string
    {
        $path = str_replace('/', DIRECTORY_SEPARATOR, $path);
        return rtrim($path, DIRECTORY_SEPARATOR);
    }

    /**
     * @return array{string, string}
     */
    protected function split(string $spec) : array
    {
        if (strpos($spec, '..') !== false) {
            throw new Exception\FileNotFound("Double-dots not allowed in template specifications: $spec");
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
