# 入門

## インストール方法

QiqはComposerから [qiq/qiq](https://packagist.org/packages/qiq/qiq) としてインストールします。

```
composer require qiq/qiq ^1.0
```

## はじめに

まず、テンプレートファイルは`/path/to/templates/hello.php`に保存されているとします。

```html+php
Hello, {{h $this->name }}. That was Qiq!

And this is PHP, <?= $this->h($this->name) ?>.
```

次は`hello` テンプレートを使って出力を生成するためのプレゼンテーションコードです。

```php
use Qiq\Template;

$tpl = Template::new('/path/to/templates');
$tpl->setView('hello');
$tpl->setData([
    'name' => 'World'
]);
echo $tpl->render();
```

これだけです。
