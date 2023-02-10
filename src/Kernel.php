<?php
declare(strict_types=1);

namespace Qiq;

use Qiq\Compiler\QiqCompiler;
use Qiq\Helper\Html\HtmlHelpers;
use stdClass;

abstract class Kernel implements Engine
{
    /**
     * @param string|string[] $paths
     */
    public static function new(
        string|array $paths = [],
        string $extension = '.php',
        Helpers $helpers = null,
        Compiler $compiler = null,
    ) : static
    {
        return new static(
            new Catalog(
                (array) $paths,
                $extension,
            ),
            $compiler ?? new QiqCompiler(),
            $helpers ?? new HtmlHelpers(),
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
        private Compiler $compiler,
        private Helpers $helpers
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
        return $this->helpers->$name(...$args);
    }

    public function getBlocks() : Blocks
    {
        return $this->blocks;
    }

    public function getCatalog() : Catalog
    {
        return $this->catalog;
    }

    public function getCompiler() : Compiler
    {
        return $this->compiler;
    }

    public function getHelpers() : Helpers
    {
        return $this->helpers;
    }

    public function getRenderStack() : RenderStack
    {
        return $this->renderStack;
    }

    public function setIndent(string $base) : void
    {
        $this->helpers->setIndent($base);
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

    public function getCompiled(string $name) : string
    {
        return $this->catalog->getCompiled($this->compiler, $name);
    }

    public function getContent() : string
    {
        return $this->content;
    }

    public function setBlock(string $name) : void
    {
        $this->blocks->set($name);
    }

    public function parentBlock() : void
    {
        $this->blocks->parent();
    }

    public function endBlock() : void
    {
        $this->blocks->end();
    }

    public function getBlock() : string
    {
        return $this->blocks->get();
    }

    abstract public function render(string $__NAME__, array $__VARS__ = []) : string;
}
