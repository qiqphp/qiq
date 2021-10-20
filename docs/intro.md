# Introduction

## Installation

Qiq is installable via Composer as [qiq/qiq](https://packagist.org/packages/qiq/qiq):

```
composer require qiq/qiq ^1.0
```

## Getting Started

First, a template file, saved at `/path/to/templates/hello.php`:

```html+php
Hello, {{h $this->name }}. That was Qiq!

And this is PHP, <?= $this->h($this->name) ?>.
```

Next, the presentation code, to generate output using the `hello` template:

```php
use Qiq\Template;

$tpl = Template::new('/path/to/templates');
$tpl->setView('hello');
$tpl->setData([
    'name' => 'World'
]);
echo $tpl->render();
```

That's all there is to it.
