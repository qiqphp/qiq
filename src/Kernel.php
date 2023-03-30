<?php
declare(strict_types=1);

namespace Qiq;

use Qiq\Compiler;
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
        string|false $cachePath = null,
        Helpers $helpers = null,
    ) : static
    {
        $compiler = $cachePath === false
            ? new Compiler\NonCompiler()
            : new Compiler\QiqCompiler($cachePath);

        $helpers ??= new HtmlHelpers();

        return new static(
            new Catalog(
                (array) $paths,
                $extension,
                $compiler
            ),
            $helpers,
        );
    }

    private Blocks $blocks;

    private string $content = '';

    /**
     * @var array<string, mixed>
     */
    private array $data = [];

    private ?string $extends = null;

    private ?string $layout = null;

    private RenderStack $renderStack;

    private ?string $view = null;

    public function __construct(
        private Catalog $catalog,
        private Helpers $helpers
    ) {
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

    /**
     * @param mixed[] $args
     */
    public function __call(string $name, array $args) : mixed
    {
        return $this->helpers->$name(...$args);
    }

    public function getCatalog() : Catalog
    {
        return $this->catalog;
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

    /** @inheritdoc */
    public function setData(array|stdClass $data) : void
    {
        $this->data = (array) $data;
    }

    /** @inheritdoc */
    public function addData(iterable $data) : void
    {
        foreach ($data as $key => $val) {
            $this->data[$key] = $val;
        }
    }

    /** @inheritdoc */
    public function getData() : array
    {
        return $this->data;
    }

    /** @inheritdoc */
    public function &refData() : array
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

    /** @inheritdoc */
    abstract public function render(string $__NAME__, array $__LOCAL__ = []) : string;
}
