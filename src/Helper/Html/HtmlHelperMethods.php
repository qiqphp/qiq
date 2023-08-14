<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

trait HtmlHelperMethods
{
    /**
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $raw
     */
    public function a(mixed $raw) : string
    {
        return $this->get(Escape::class)->a($raw);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function anchor(
        string $href,
        string $text,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this->get(Anchor::class)->__invoke($href, $text, $attr, ...$__attr);
    }

    public function base(string $href) : string
    {
        return $this->get(Base::class)->__invoke($href);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function button(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this->get(Button::class)->__invoke($name, $value, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $raw
     */
    public function c(mixed $raw) : string
    {
        return $this->get(Escape::class)->c($raw);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function checkboxField(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this
            ->get(CheckboxField::class)
            ->__invoke($name, $value, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $value
     * @param array<null|scalar|\Stringable, null|scalar|\Stringable> $options
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function checkboxFields(
        ?string $name = null,
        mixed $value = null,
        array $options = [],
        mixed $default = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this
            ->get(CheckboxFields::class)
            ->__invoke($name, $value, $options, $default, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function colorField(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this
            ->get(ColorField::class)
            ->__invoke($name, $value, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function dateField(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this->get(DateField::class)->__invoke($name, $value, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function datetimeField(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this
            ->get(DatetimeField::class)
            ->__invoke($name, $value, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function datetimeLocalField(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this
            ->get(DatetimeLocalField::class)
            ->__invoke($name, $value, $attr, ...$__attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $terms
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function dl(array $terms, array $attr = [], mixed ...$__attr) : string
    {
        return $this->get(Dl::class)->__invoke($terms, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function emailField(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this
            ->get(EmailField::class)
            ->__invoke($name, $value, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function fileField(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this->get(FileField::class)->__invoke($name, $value, $attr, ...$__attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function form(
        string $method = 'post',
        string $action = '',
        string $enctype = 'multipart/form-data',
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this
            ->get(Form::class)
            ->__invoke($method, $action, $enctype, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $raw
     */
    public function h(mixed $raw) : string
    {
        return $this->get(Escape::class)->h($raw);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function hiddenField(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this
            ->get(HiddenField::class)
            ->__invoke($name, $value, $attr, ...$__attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function image(string $src, array $attr = [], mixed ...$__attr) : string
    {
        return $this->get(Image::class)->__invoke($src, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function imageButton(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this
            ->get(ImageButton::class)
            ->__invoke($name, $value, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function inputField(
        string $type,
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this
            ->get(InputField::class)
            ->__invoke($type, $name, $value, $attr, ...$__attr);
    }

    /**
     * @param array<null|scalar|\Stringable> $items
     */
    public function items(array $items) : string
    {
        return $this->get(Items::class)->__invoke($items);
    }

    /**
     * @param null|scalar|\Stringable $raw
     */
    public function j(mixed $raw) : string
    {
        return $this->get(Escape::class)->j($raw);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function label(string $text, array $attr = [], mixed ...$__attr) : string
    {
        return $this->get(Label::class)->__invoke($text, $attr, ...$__attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function link(
        string $rel,
        string $href,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this->get(Link::class)->__invoke($rel, $href, $attr, ...$__attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function linkStylesheet(
        string $href,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this->get(LinkStylesheet::class)->__invoke($href, $attr, ...$__attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function meta(array $attr = [], mixed ...$__attr) : string
    {
        return $this->get(Meta::class)->__invoke($attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function monthField(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this
            ->get(MonthField::class)
            ->__invoke($name, $value, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function numberField(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this
            ->get(NumberField::class)
            ->__invoke($name, $value, $attr, ...$__attr);
    }

    /**
     * @param array<null|scalar|\Stringable> $items
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function ol(array $items, array $attr = [], mixed ...$__attr) : string
    {
        return $this->get(Ol::class)->__invoke($items, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function passwordField(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this
            ->get(PasswordField::class)
            ->__invoke($name, $value, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function radioField(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this
            ->get(RadioField::class)
            ->__invoke($name, $value, $attr, ...$__attr);
    }

    /**
     * @param array<null|scalar|\Stringable, null|scalar|\Stringable> $options
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function radioFields(
        ?string $name = null,
        mixed $value = null,
        array $options = [],
        mixed $default = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this
            ->get(RadioFields::class)
            ->__invoke($name, $value, $options, $default, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function rangeField(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this
            ->get(RangeField::class)
            ->__invoke($name, $value, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function resetButton(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this
            ->get(ResetButton::class)
            ->__invoke($name, $value, $attr, ...$__attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function script(string $src, array $attr = [], mixed ...$__attr) : string
    {
        return $this->get(Script::class)->__invoke($src, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function searchField(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this
            ->get(SearchField::class)
            ->__invoke($name, $value, $attr, ...$__attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $options
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function select(
        ?string $name = null,
        mixed $value = null,
        array $options = [],
        bool $multiple = false,
        ?string $placeholder = null,
        mixed $default = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this
            ->get(
                Select::class,
            )
            ->__invoke(
                $name,
                $value,
                $options,
                $multiple,
                $placeholder,
                $default,
                $attr,
                ...$__attr,
            );
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function submitButton(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this
            ->get(SubmitButton::class)
            ->__invoke($name, $value, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function telField(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this->get(TelField::class)->__invoke($name, $value, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function textarea(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this->get(Textarea::class)->__invoke($name, $value, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function textField(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this->get(TextField::class)->__invoke($name, $value, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function timeField(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this->get(TimeField::class)->__invoke($name, $value, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $raw
     */
    public function u(mixed $raw) : string
    {
        return $this->get(Escape::class)->u($raw);
    }

    /**
     * @param array<null|scalar|\Stringable> $items
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function ul(array $items, array $attr = [], mixed ...$__attr) : string
    {
        return $this->get(Ul::class)->__invoke($items, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function urlField(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this->get(UrlField::class)->__invoke($name, $value, $attr, ...$__attr);
    }

    /**
     * @param null|scalar|\Stringable $value
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     * @param null|scalar|\Stringable|array<null|scalar|\Stringable> $__attr
     */
    public function weekField(
        ?string $name = null,
        mixed $value = null,
        array $attr = [],
        mixed ...$__attr,
    ) : string
    {
        return $this->get(WeekField::class)->__invoke($name, $value, $attr, ...$__attr);
    }
}
