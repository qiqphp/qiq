# Introduction

## Installation

Qiq is installable via Composer as [qiq/qiq](https://packagist.org/packages/qiq/qiq):

```
composer require qiq/qiq ^2.0
```

## Getting Started

First, a template file, saved at `/path/to/templates/hello.php`:

```html+php
Hello, {{h $name }}. That was Qiq!

And this is PHP, <?= $this->h($name) ?>.
```

Next, the presentation code, to generate output using the `hello` template:

```php
use Qiq\Template;

$template = Template::new('/path/to/templates');
$template->setView('hello');
$template->setData([
    'name' => 'World'
]);
echo $template();
```

That's all there is to it.
