<?php
namespace Qiq;

class RenderStack
{
    protected array $names = [];

    public function push(string $name) : string
    {
        $resolved = str_starts_with($name, '.')
            ? $this->relative($name, $this->dirname(end($this->names)))
            : $name;

        if (strpos($resolved, '..') !== false) {
            throw new Exception\TemplateNotFound(
                PHP_EOL . "Could not resolve dots in template name." .
                PHP_EOL . "Original name: '{$name}'" .
                PHP_EOL . "Resolved into: '{$resolved}'" .
                PHP_EOL . "Probably too many '../' in the original name."
            );
        }

        array_push($this->names, $resolved);
        return $resolved;
    }

    public function pop() : void
    {
        array_pop($this->names);
    }

    public function reset() : void
    {
        $this->names = [];
    }

    protected function relative(string $name, string $dirname) : string
    {
        $name = ltrim(trim($name), '/');

        if (str_starts_with($name, './')) {
            $name = substr($name, 2);
            return $this->relative($name, $dirname);
        }

        if ($dirname && str_starts_with($name, '../')) {
            $name = substr($name, 3);
            $dirname = $this->dirname($dirname);
            return $this->relative($name, $dirname);
        }

        return $dirname ? ($dirname . '/' . $name) : $name;
    }

    protected function dirname(bool|string $name) : string
    {
        $name = trim((string) $name);
        $parts = explode('/', $name);
        array_pop($parts);
        return trim(implode('/', $parts));
    }
}
