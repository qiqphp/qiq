<?php
namespace Qiq;

class Indent
{
    protected static string $indent = '    ';

    protected static string $base = '';

    protected static int $level = 0;

    public static function set(string $base) : void
    {
        static::$base = $base;
    }

    public static function level(int $level) : void
    {
        static::$level += $level;
    }

    public static function get(int $add = 0) : string
    {
        return static::$base
            . str_repeat(static::$indent, static::$level + $add);
    }
}
