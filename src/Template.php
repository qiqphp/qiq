<?php
namespace Qiq;

use Qiq\Compiler\QiqCompiler;
use Throwable;

/**
 * @method string h(string $raw)
 * @method string a(string $raw)
 * @method string u(string $raw)
 * @method string c(string $raw)
 * @method string j(string $raw)
 * @method string ol(array $items, array $attr)
 * @method string passwordField(array $attr)
 * @method string weekField(array $attr)
 * @method string items(array $items)
 * @method string hiddenField(array $attr)
 * @method string metaName(string $name, string $content)
 * @method string fileField(array $attr)
 * @method string datetimeField(array $attr)
 * @method string rangeField(array $attr)
 * @method string link(string $rel, string $href, array $attr)
 * @method string inputField(array $attr)
 * @method string imageButton(array $attr)
 * @method string submitButton(array $attr)
 * @method string urlField(array $attr)
 * @method string label(string $text, array $attr)
 * @method string colorField(array $attr)
 * @method string datetimeLocalField(array $attr)
 * @method string numberField(array $attr)
 * @method string telField(array $attr)
 * @method string meta(array $attr)
 * @method string escapeJs(string $raw)
 * @method string searchField(array $attr)
 * @method string dl(array $terms, array $attr)
 * @method string linkStylesheet(string $href, array $attr)
 * @method string radioField(array $attr)
 * @method string monthField(array $attr)
 * @method string script(string $src, array $attr)
 * @method string metaHttp(string $equiv, string $content)
 * @method string emailField(array $attr)
 * @method string base(string $href)
 * @method string textField(array $attr)
 * @method string escapeCss(string $raw)
 * @method string resetButton(array $attr)
 * @method string textarea(array $attr)
 * @method string select(array $attr)
 * @method string escapeHtml(string $raw)
 * @method string anchor(string $href, string $text, array $attr)
 * @method string form(array $attr)
 * @method string dateField(array $attr)
 * @method string checkboxField(array $attr)
 * @method string ul(array $items, array $attr)
 * @method string escapeAttr(array|string $raw)
 * @method string escapeUrl(string $raw)
 * @method string timeField(array $attr)
 * @method string image(string $src, array $attr)
 * @method string button(array $attr)
 */
class Template extends TemplateCore
{
    static public function new(
        string|array $paths = [],
        string $extension = '.php',
        string $encoding = 'utf-8',
        string $cachePath = null
    ) : self
    {
        $helperLocator = HelperLocator::new(new Escape($encoding));
        $compiler = new QiqCompiler($cachePath);

        return new self(
            new TemplateLocator((array) $paths, $extension, $compiler),
            $helperLocator
        );
    }

    public function render(string $__NAME__, array $__VARS__ = []) : string
    {
        try {
            $__OBLEVEL__ = ob_get_level();
            ob_start();
            extract($__VARS__, EXTR_SKIP);
            require $this->getTemplate($__NAME__);
            return (string) ob_get_clean();
        } catch (Throwable $e) {
            while (ob_get_level() > $__OBLEVEL__) {
                ob_end_clean();
            }
            throw $e;
        }
    }
}
