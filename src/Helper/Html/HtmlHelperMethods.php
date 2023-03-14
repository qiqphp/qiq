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
        return $this
            ->get(Escape::class)
            ->a($raw);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function anchor(string $href, string $text, array $attr = []) : string
    {
        return $this
            ->get(Anchor::class)
            ->__invoke($href, $text, $attr);
    }

    public function base(string $href) : string
    {
        return $this
            ->get(Base::class)
            ->__invoke($href);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function button(array $attr) : string
    {
        return $this
            ->get(Button::class)
            ->__invoke($attr);
    }

    /**
     * @param null|scalar|\Stringable $raw
     */
    public function c(mixed $raw) : string
    {
        return $this
            ->get(Escape::class)
            ->c($raw);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>>|array<array<null|scalar|\Stringable|array<null|scalar|\Stringable>>> $attr
     */
    public function checkboxField(array $attr) : string
    {
        return $this
            ->get(CheckboxField::class)
            ->__invoke($attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function colorField(array $attr) : string
    {
        return $this
            ->get(ColorField::class)
            ->__invoke($attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function dateField(array $attr) : string
    {
        return $this
            ->get(DateField::class)
            ->__invoke($attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function datetimeField(array $attr) : string
    {
        return $this
            ->get(DatetimeField::class)
            ->__invoke($attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function datetimeLocalField(array $attr) : string
    {
        return $this
            ->get(DatetimeLocalField::class)
            ->__invoke($attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $terms
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function dl(array $terms, array $attr = []) : string
    {
        return $this
            ->get(Dl::class)
            ->__invoke($terms, $attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function emailField(array $attr) : string
    {
        return $this
            ->get(EmailField::class)
            ->__invoke($attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function fileField(array $attr) : string
    {
        return $this
            ->get(FileField::class)
            ->__invoke($attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function form(array $attr) : string
    {
        return $this
            ->get(Form::class)
            ->__invoke($attr);
    }

    /**
     * @param null|scalar|\Stringable $raw
     */
    public function h(mixed $raw) : string
    {
        return $this
            ->get(Escape::class)
            ->h($raw);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function hiddenField(array $attr) : string
    {
        return $this
            ->get(HiddenField::class)
            ->__invoke($attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function image(string $src, array $attr = []) : string
    {
        return $this
            ->get(Image::class)
            ->__invoke($src, $attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function imageButton(array $attr) : string
    {
        return $this
            ->get(ImageButton::class)
            ->__invoke($attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function inputField(array $attr) : string
    {
        return $this
            ->get(InputField::class)
            ->__invoke($attr);
    }

    /**
     * @param array<null|scalar|\Stringable> $items
     */
    public function items(array $items) : string
    {
        return $this
            ->get(Items::class)
            ->__invoke($items);
    }

    /**
     * @param null|scalar|\Stringable $raw
     */
    public function j(mixed $raw) : string
    {
        return $this
            ->get(Escape::class)
            ->j($raw);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function label(string $text, array $attr = []) : string
    {
        return $this
            ->get(Label::class)
            ->__invoke($text, $attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function link(string $rel, string $href, array $attr = []) : string
    {
        return $this
            ->get(Link::class)
            ->__invoke($rel, $href, $attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function linkStylesheet(string $href, array $attr = []) : string
    {
        return $this
            ->get(LinkStylesheet::class)
            ->__invoke($href, $attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function meta(array $attr) : string
    {
        return $this
            ->get(Meta::class)
            ->__invoke($attr);
    }

    public function metaHttp(string $equiv, string $content) : string
    {
        return $this
            ->get(MetaHttp::class)
            ->__invoke($equiv, $content);
    }

    public function metaName(string $name, string $content) : string
    {
        return $this
            ->get(MetaName::class)
            ->__invoke($name, $content);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function monthField(array $attr) : string
    {
        return $this
            ->get(MonthField::class)
            ->__invoke($attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function numberField(array $attr) : string
    {
        return $this
            ->get(NumberField::class)
            ->__invoke($attr);
    }

    /**
     * @param array<null|scalar|\Stringable> $items
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function ol(array $items, array $attr = []) : string
    {
        return $this
            ->get(Ol::class)
            ->__invoke($items, $attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function passwordField(array $attr) : string
    {
        return $this
            ->get(PasswordField::class)
            ->__invoke($attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function radioField(array $attr) : string
    {
        return $this
            ->get(RadioField::class)
            ->__invoke($attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function rangeField(array $attr) : string
    {
        return $this
            ->get(RangeField::class)
            ->__invoke($attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function resetButton(array $attr) : string
    {
        return $this
            ->get(ResetButton::class)
            ->__invoke($attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function script(string $src, array $attr = []) : string
    {
        return $this
            ->get(Script::class)
            ->__invoke($src, $attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function searchField(array $attr) : string
    {
        return $this
            ->get(SearchField::class)
            ->__invoke($attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>>|array<array<null|scalar|\Stringable|array<null|scalar|\Stringable>>> $attr
     */
    public function select(array $attr) : string
    {
        return $this
            ->get(Select::class)
            ->__invoke($attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function submitButton(array $attr) : string
    {
        return $this
            ->get(SubmitButton::class)
            ->__invoke($attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function telField(array $attr) : string
    {
        return $this
            ->get(TelField::class)
            ->__invoke($attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function textarea(array $attr) : string
    {
        return $this
            ->get(Textarea::class)
            ->__invoke($attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function textField(array $attr) : string
    {
        return $this
            ->get(TextField::class)
            ->__invoke($attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function timeField(array $attr) : string
    {
        return $this
            ->get(TimeField::class)
            ->__invoke($attr);
    }

    /**
     * @param null|scalar|\Stringable $raw
     */
    public function u(mixed $raw) : string
    {
        return $this
            ->get(Escape::class)
            ->u($raw);
    }

    /**
     * @param array<null|scalar|\Stringable> $items
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function ul(array $items, array $attr = []) : string
    {
        return $this
            ->get(Ul::class)
            ->__invoke($items, $attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function urlField(array $attr) : string
    {
        return $this
            ->get(UrlField::class)
            ->__invoke($attr);
    }

    /**
     * @param array<null|scalar|\Stringable|array<null|scalar|\Stringable>> $attr
     */
    public function weekField(array $attr) : string
    {
        return $this
            ->get(WeekField::class)
            ->__invoke($attr);
    }
}
