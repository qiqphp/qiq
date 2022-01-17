# 概要

ヘルパーはHTMLを生成してくれる呼び出し可能なオブジェクトです。PHPのテンプレートコードでは`$this`のメソッドとして、Qiq構文ではヘルパーの名前として指定することができます。

PHPの構文

```html+php
<?= $this->anchor('http://qiqphp.com', 'Qiq for PHP') ?>
```

Qiqの構文

```qiq
{{= anchor ('http://qiqphp.com', 'Qiq for PHP') }}
```

どちらもこのようなHTMLが生成されます

```html
<a href="http://qiqphp.com">Qiq for PHP</a>
```

Qiqには、[一般的な使用](./general.md)や[フォームを作成](./forms.md)するための包括的なヘルパーセットが付属しています。また、独自の[カスタムヘルパー](./custom.md)を作成することもできます。

さらに、テンプレートコードから任意のpublicまたはprotectedのTemplateメソッドを呼び出すことができます。(これは、テンプレートコードがTemplateオブジェクトの「内部」で実行されるためです）。特に、レイアウトの設定や他のテンプレートのレンダリングは、テンプレートの内部から行うことができます。

```qiq
{{ setLayout ('seasonal-layout') }}

{{= render ('some/other/template') }}
```
