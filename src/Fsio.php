<?php
namespace Qiq;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use FilesystemIterator;

class Fsio
{
    static public function osdirsep($path)
    {
        return str_replace('/', DIRECTORY_SEPARATOR, $path);
    }

    static public function isReadable($path) : bool
    {
        return is_readable(static::osdirsep($path));
    }

    static public function isDir($path)
    {
        return is_dir(static::osdirsep($path));
    }

    static public function fileGetContents($path)
    {
        return file_get_contents(static::osdirsep($path));
    }

    static public function filePutContents($path, $text)
    {
        return file_put_contents(static::osdirsep($path), $text);
    }

    static public function rrmdir($path)
    {
        if (! static::isDir($path)) {
            return;
        }

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                static::osdirsep($path),
                FilesystemIterator::SKIP_DOTS
            ),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getPathname());
            } else {
                unlink($file->getPathname());
            }
        }
    }

    static public function mkdir($path, $perm, $deep)
    {
        return mkdir(static::osdirsep($path), $perm, $deep);
    }

    static public function filemtime($path)
    {
        return filemtime(static::osdirsep($path));
    }

    static public function trim(string $path)
    {
        return trim(static::osdirsep($path), DIRECTORY_SEPARATOR);
    }

    static public function rtrim(string $path)
    {
        return rtrim(static::osdirsep($path), DIRECTORY_SEPARATOR);
    }

    static public function ltrim(string $path)
    {
        if (
            PHP_OS_FAMILY === 'Windows'
            && substr($path, 1, 1) === ':'
        ) {
            $path = substr($path, 2);
        }

        return ltrim(static::osdirsep($path), DIRECTORY_SEPARATOR);
    }

    static public function concat(...$parts)
    {
        $path = array_shift($parts);

        while (! empty($parts)) {
            $part = array_shift($parts);
            $part = DIRECTORY_SEPARATOR . static::ltrim($part);
            $path .= static::rtrim($part);
        }

        return $path;
    }
}
