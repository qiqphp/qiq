<?php
namespace Qiq;

use stdClass;

abstract class TemplateCore
{
    private string $content = '';

    private stdClass $data;

    private ?string $layout = null;

    private array $sections = [];

    private array $sectionStack = [];

    private ?string $view = null;

    public function __construct(
        private TemplateLocator $templateLocator,
        private HelperLocator $helperLocator
    ) {
        $this->data = new stdClass();
    }

    public function __invoke() : string
    {
        $view = $this->getView();
        $this->content = ($view === null) ? '' : $this->render($view);
        $layout = $this->getLayout();

        if ($layout === null) {
            return $this->content;
        }

        return $this->render($layout);
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

    public function getHelperLocator() : object
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

    public function getTemplateLocator() : TemplateLocator
    {
        return $this->templateLocator;
    }

    protected function getTemplate(string $name) : string
    {
        return $this->templateLocator->get($name);
    }

    protected function getContent() : string
    {
        return $this->content;
    }

    protected function hasSection(string $name) : bool
    {
        return isset($this->sections[$name]);
    }

    protected function getSection(string $name) : ?string
    {
        return $this->sections[$name] ?? null;
    }

    protected function setSection(string $name) : void
    {
        $this->sectionStack[] = [__FUNCTION__, $name];
        ob_start();
    }

    protected function appendSection(string $name) : void
    {
        $this->sectionStack[] = [__FUNCTION__, $name];
        ob_start();
    }

    protected function prependSection(string $name) : void
    {
        $this->sectionStack[] = [__FUNCTION__, $name];
        ob_start();
    }

    protected function endSection() : void
    {
        list($func, $name) = array_pop($this->sectionStack);
        $buffer = (string) ob_get_clean();

        if (! $this->hasSection($name)) {
            $this->sections[$name] = '';
        }

        switch ($func) {
            case 'appendSection':
                $this->sections[$name] .= $buffer;
                return;
            case 'prependSection':
                $this->sections[$name] = $buffer . $this->sections[$name];
                return;
            default:
                $this->sections[$name] = $buffer;
                return;
        }
    }

    abstract protected function render(string $__NAME__, array $__VARS__ = []) : string;
}
