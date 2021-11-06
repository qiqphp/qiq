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
        $this->cachePath ??= Fsio::concat(sys_get_temp_dir(), 'qiq');
    }

    public function __invoke(string $source) : string
    {
        $cached = Fsio::concat($this->cachePath, $source);

        if (! $this->isCompiled($source, $cached)) {
            $text = (string) Fsio::fileGetContents($source);
            $code = $this->compile($text);
            Fsio::filePutContents($cached, $code);
        }

        return $cached;
    }

    public function clear() : void
    {
        Fsio::rrmdir($this->cachePath);
    }

    protected function isCompiled(string $source, string $cached) : bool
    {
        $dir = dirname($cached);

        if (! Fsio::isDir($dir)) {
            Fsio::mkdir($dir, 0777, true);
            return false;
        }

        if (! Fsio::isReadable($cached)) {
            return false;
        }

        if (Fsio::filemtime($cached) < Fsio::filemtime($source)) {
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
