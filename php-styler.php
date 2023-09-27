<?php
use PhpStyler\Config;
use PhpStyler\Files;
use PhpStyler\Styler;
use Symfony\Component\Finder\Finder;

$finder = (new Finder())
    ->files()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
    ->exclude('templates');

return new Config(
    files: $finder,
    styler: new Styler(),
    cache: __DIR__ . '/.php-styler.cache',
);
