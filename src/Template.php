<?php
namespace Qiq;

use Qiq\Compiler\Compiler;
use Qiq\Compiler\QiqCompiler;
use Throwable;

class Template extends TemplateCore
{
    static public function new(
        string|array $paths = [],
        string $extension = '.php',
        string $encoding = 'utf-8',
        string $cachePath = null,
        HelperLocator $helperLocator = null,
        Compiler $compiler = null,
    ) : static
    {
        $helperLocator ??= HelperLocator::new(new Escape($encoding));
        $compiler ??= new QiqCompiler($cachePath);

        return new static(
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
            $__NAME__ = $this->getRenderStack()->push($__NAME__);
            require $this->getTemplate($__NAME__);
            $this->getRenderStack()->pop();
            return (string) ob_get_clean();
        } catch (Throwable $e) {
            while (ob_get_level() > $__OBLEVEL__) {
                ob_end_clean();
            }
            throw $e;
        }
    }
}
