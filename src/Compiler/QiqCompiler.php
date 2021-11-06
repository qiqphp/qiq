<?php
namespace Qiq\Compiler;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Qiq\Fsio;

class QiqCompiler implements Compiler
{
    public function __construct(protected ?string $cachePath = null)
    {
        $this->cachePath ??= sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'qiq';
    }

    public function __invoke(string $source) : string
    {
        $append = (PHP_OS_FAMILY === 'Windows')
            ? substr($source, 2)
            : $source;

        $cached = $this->cachePath . $append;

        if (! $this->isCompiled($source, $cached)) {
            $text = (string) file_get_contents($source);
            $code = $this->compile($text);
            file_put_contents($cached, $code);
        }

        return $cached;
    }

    public function clear() : void
    {
        if (! is_dir($this->cachePath)) {
            return;
        }

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $this->cachePath,
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

    protected function isCompiled(string $source, string $cached) : bool
    {
        $dir = dirname($cached);

        if (! is_dir($dir)) {
            mkdir($dir, 0777, true);
            return false;
        }

        if (! is_readable($cached)) {
            return false;
        }

        if (filemtime($cached) < filemtime($source)) {
            return false;
        }

        return true;
    }

    protected function compile(string $text) : string
    {
        $parts = preg_split(
            '/(\s*{{.*?}}\s*)/ms',
            $text,
            -1,
            PREG_SPLIT_DELIM_CAPTURE
        );

        $compiled = '';

        foreach ((array) $parts as $part) {
            $token = $this->newToken((string) $part);
            $compiled .= ($token === null) ? $this->embrace((string) $part) : $token;
        }

        return $compiled;
    }

    protected function embrace(string $part) : string
    {
        return strtr($part, [
            '{\\{' => '{{',
            '}\\}' => '}}',
        ]);
    }

    protected function newToken(string $part) : ?QiqToken
    {
        return QiqToken::new($part);
    }
}
