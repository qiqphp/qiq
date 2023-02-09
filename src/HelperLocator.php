<?php
declare(strict_types=1);

namespace Qiq;

class HelperLocator
{
    public static function new(Escape $escape = null, array $factories = []) : static
    {
        $escape ??= new Escape('utf-8');

        $default = [
            'a'                     => function () use ($escape) { return new Helper\EscapeAttr($escape); },
            'anchor'                => function () use ($escape) { return new Helper\Anchor($escape); },
            'base'                  => function () use ($escape) { return new Helper\Base($escape); },
            'button'                => function () use ($escape) { return new Helper\Button($escape); },
            'c'                     => function () use ($escape) { return new Helper\EscapeCss($escape); },
            'checkboxField'         => function () use ($escape) { return new Helper\CheckboxField($escape); },
            'colorField'            => function () use ($escape) { return new Helper\ColorField($escape); },
            'dateField'             => function () use ($escape) { return new Helper\DateField($escape); },
            'datetimeField'         => function () use ($escape) { return new Helper\DatetimeField($escape); },
            'datetimeLocalField'    => function () use ($escape) { return new Helper\DatetimeLocalField($escape); },
            'dl'                    => function () use ($escape) { return new Helper\Dl($escape); },
            'emailField'            => function () use ($escape) { return new Helper\EmailField($escape); },
            'escape'                => function () use ($escape) { return $escape; },
            'fileField'             => function () use ($escape) { return new Helper\FileField($escape); },
            'form'                  => function () use ($escape) { return new Helper\Form($escape); },
            'h'                     => function () use ($escape) { return new Helper\EscapeHtml($escape); },
            'hiddenField'           => function () use ($escape) { return new Helper\HiddenField($escape); },
            'image'                 => function () use ($escape) { return new Helper\Image($escape); },
            'imageButton'           => function () use ($escape) { return new Helper\ImageButton($escape); },
            'inputField'            => function () use ($escape) { return new Helper\InputField($escape); },
            'items'                 => function () use ($escape) { return new Helper\Items($escape); },
            'j'                     => function () use ($escape) { return new Helper\EscapeJs($escape); },
            'label'                 => function () use ($escape) { return new Helper\Label($escape); },
            'link'                  => function () use ($escape) { return new Helper\Link($escape); },
            'linkStylesheet'        => function () use ($escape) { return new Helper\LinkStylesheet($escape); },
            'meta'                  => function () use ($escape) { return new Helper\Meta($escape); },
            'metaHttp'              => function () use ($escape) { return new Helper\MetaHttp($escape); },
            'metaName'              => function () use ($escape) { return new Helper\MetaName($escape); },
            'monthField'            => function () use ($escape) { return new Helper\MonthField($escape); },
            'numberField'           => function () use ($escape) { return new Helper\NumberField($escape); },
            'ol'                    => function () use ($escape) { return new Helper\Ol($escape); },
            'passwordField'         => function () use ($escape) { return new Helper\PasswordField($escape); },
            'radioField'            => function () use ($escape) { return new Helper\RadioField($escape); },
            'rangeField'            => function () use ($escape) { return new Helper\RangeField($escape); },
            'resetButton'           => function () use ($escape) { return new Helper\ResetButton($escape); },
            'script'                => function () use ($escape) { return new Helper\Script($escape); },
            'searchField'           => function () use ($escape) { return new Helper\SearchField($escape); },
            'select'                => function () use ($escape) { return new Helper\Select($escape); },
            'submitButton'          => function () use ($escape) { return new Helper\SubmitButton($escape); },
            'telField'              => function () use ($escape) { return new Helper\TelField($escape); },
            'textarea'              => function () use ($escape) { return new Helper\Textarea($escape); },
            'textField'             => function () use ($escape) { return new Helper\TextField($escape); },
            'timeField'             => function () use ($escape) { return new Helper\TimeField($escape); },
            'u'                     => function () use ($escape) { return new Helper\EscapeUrl($escape); },
            'ul'                    => function () use ($escape) { return new Helper\Ul($escape); },
            'urlField'              => function () use ($escape) { return new Helper\UrlField($escape); },
            'weekField'             => function () use ($escape) { return new Helper\WeekField($escape); },
        ];

        $helper_factories = array_merge($default, $factories);

        return new static($helper_factories);
    }

    protected array $factories = [];

    protected array $instances = [];

    public function __construct(array $factories = [])
    {
        $this->factories = $factories;
    }

    public function __call(string $name, array $args) : mixed
    {
        /** @var callable */
        $callable = $this->get($name);
        return $callable(...$args);
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
