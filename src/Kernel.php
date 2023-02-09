<?php
declare(strict_types=1);

namespace Qiq;

use Qiq\Compiler\QiqCompiler;
use stdClass;

abstract class Kernel
{
    public static function new(
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
            new Catalog((array) $paths, $extension, $compiler),
            $helperLocator
        );
    }

    private Blocks $blocks;

    private string $content = '';

    private stdClass $data;

    private ?string $extends = null;

    private ?string $layout = null;

    private RenderStack $renderStack;

    private ?string $view = null;

    public function __construct(
        private Catalog $catalog,
        private HelperLocator $helperLocator
    ) {
        $this->data = new stdClass();
        $this->blocks = new Blocks();
        $this->renderStack = new RenderStack();
    }

    public function __invoke() : string
    {
        $this->blocks->reset();
        $this->content = '';
        $this->renderStack->reset();

        $view = $this->getView();
        $this->content = ($view === null) ? '' : $this->render($view);

        while ($parentView = $this->extends) {
            $this->extends = null;
            $this->content = $this->render($parentView);
        }

        $layout = $this->getLayout();

        if ($layout === null) {
            return $this->content;
        }

        $output = $this->render($layout);

        while ($parentLayout = $this->extends) {
            $this->extends = null;
            $output = $this->render($parentLayout);
        }

        return $output;
    }

    public function __get(string $key) : mixed
    {
        return $this->data->$key;
    }

    public function __set(string $key, mixed $val) : void
    {
        $this->data->$key = $val;
    }

    public function __isset(string $key) : bool
    {
        return isset($this->data->$key);
    }

    public function __unset(string $key) : void
    {
        unset($this->data->$key);
    }

    public function __call(string $name, array $args) : mixed
    {
        return $this->helperLocator->$name(...$args);
    }

    public function setData(array|stdClass $data) : void
    {
        $this->data = (object) $data;
    }

    public function addData(iterable $data) : void
    {
        foreach ($data as $key => $val) {
            $this->data->$key = $val;
        }
    }

    public function getData() : stdClass
    {
        return $this->data;
    }

    public function getHelperLocator() : HelperLocator
    {
        return $this->helperLocator;
    }

    public function setLayout(?string $layout) : void
    {
        $this->layout = $layout;
    }

    public function getLayout() : ?string
    {
        return $this->layout;
    }

    public function setView(?string $view) : void
    {
        $this->view = $view;
    }

    public function getView() : ?string
    {
        return $this->view;
    }

    public function extends(string $extends) : void
    {
        $this->extends = $this->renderStack->resolve($extends);
    }

    public function getCatalog() : Catalog
    {
        return $this->catalog;
    }

    public function hasTemplate(string $name) : bool
    {
        return $this->catalog->has($name);
    }

    protected function getRenderStack() : RenderStack
    {
        return $this->renderStack;
    }

    protected function getTemplate(string $name) : string
    {
        return $this->catalog->get($name);
    }

    protected function getContent() : string
    {
        return $this->content;
    }

    protected function setBlock(string $name) : void
    {
        $this->blocks->set($name);
    }

    protected function parentBlock() : void
    {
        $this->blocks->parent();
    }

    protected function endBlock() : void
    {
        $this->blocks->end();
    }

    protected function getBlock() : string
    {
        return $this->blocks->get();
    }

    abstract protected function render(string $__NAME__, array $__VARS__ = []) : string;
}
