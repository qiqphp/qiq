# テンプレートの構文

QiqテンプレートはネイティブPHPテンプレートのオプションの`{{ ... }}`構文で、簡潔なエスケープとヘルパーを使用できます。

## エスケープと出力

Qiqは、開始タグが認識可能なエスケープ文字で始まらない限り出力されません。

- `{{ ... }}` これだけでは出力は表示されません。
- `{{= ... }}` エスケープされていない生の出力を表示します。
- `{{h ... }}` HTMLコンテンツをエスケープして表示します。
- `{{a ... }}` HTML属性をエスケープして表示します。
- `{{u ... }}` URLをエスケープして表示します。
- `{{c ... }}` CSSをエスケープして表示します。
- `{{j ... }}` JavaScriptをエスケープして表示します。

`{{a ... }}`タグは、keyを属性ラベル、valueを属性値として配列を出力する追加機能を提供します。複数の属性値はスペースで区切られます。

次のQiqコードは

```qiq
<span {{a ['id' => 'foo', 'class' => ['bar', 'baz', 'dib']] }}>Text</span>
```

次のようにレンダリングされます。

```html
<span id="foo" class="bar baz dib">Text</span>
```

変数、リテラル、関数、メソッド、式、定数、魔法の定数 `__DIR__`,`__FILE__`,`__LINE__`などをエコーすることができます。

```qiq
{{h $this->foo }}
{{h $foo }}
{{h "foo" }}
{{h 1 + 2 }}
{{h __FILE__ }}
{{h PHP_EOL }}
{{h $person->firstName() }}
{{h time() }}
```

二重中括弧をQiqタグとして解釈せず、文字通り埋め込む必要がある場合は中括弧の間にバックスラッシュを入れてください。 次のQiqコードは

```qiq
{{ /* this is qiq code */ }}

{\{ this is not qiq code }\}
```

このPHPコードにコンパイルされます。

```html+php
<?php /* this is qiq code */ ?>

{{ this is not qiq code }}
```

## 制御構造

すべての制御構造は、PHPと全く同じように記述されます。
可能な場合は、[制御構造に関する別の構文](alternative control structure syntax)を使って、`{{ ... }}`Qiqタグの中に記述します。

例えば、このQiqコードは

```qiq
{{ foreach ($foo as $bar => $baz): }}
    {{ if ($baz === 0): }}
        {{= "First element!" }}
    {{ else: }}
        {{= "Not the first element." }}
    {{ endif }}
{{ endforeach }}
```

このPHPのコードと同じです。

```html+php
<?php foreach ($foo as $bar => $baz): ?>
    <?php if ($bar === 0): ?>
        <?= "First element!" ?><?= PHP_EOL ?>
    <?php else: ?>
        <?= "Not the first element." ?><?= PHP_EOL ?>
    <?php endif ?>
<?php endforeach ?>
```

Qiqの構文は、ほとんどのPHP制御構造を認識します。

- `break`
- `continue`
- `declare`
- `for`, `endfor`
- `foreach`, `endforeach`
- `goto`
- `if`, `elseif`, `else`, `endif`
- `include`, `include_once`
- `require`, `require_once`
- `while`, `endwhile`

Qiqは、`else if`、`switch`、`case`、あるいは`match`を認識しません。
あなたはいつでもプレーンなPHPに戻ることができます。

## 予約語

Qiqは以下の予約語を認識します。

- `empty`
- `isset`
- `list`
- `namespace`
- `use`

## ヘルパー

Qiqが認識しないオープニング・キーワードは、テンプレート・ヘルパー・メソッドとして扱われます。
以下の Qiq構文は

```qiq
{{= label ("Street Address", ['for' => 'street']) }}
{{= textField ([
    'name' => 'street',
    'value' => $this->street,
]) }}
```

Qiqヘルパーを使ったこのPHPコードと同等です。

```html+php
<?= $this->label("Street Address", ['for' => 'street']) ?>
<?= $this->textField([
    'name' => 'street',
    'value' => $this->street,
]) ?>
```

## その他のPHPコード

Qiqは`{{ ... }}`内の他のすべてのコードを扱います。
タグの中にあるその他のコードは、古いPHPコードとして扱われます。
例えば、このQiq構文は

```qiq
{{ $title = "Prefix: " . $this->title . " (Suffix)" }}
<title>{{h $title}}</title>
```

Qiqヘルパーを使ったこのPHPコードと同等です。

```html+php
<?php $title = "Prefix: " . $this->title . " (Suffix)" ?>
<title><?= $this->h($title) ?></title>
```

## ホワイトスペース

Qiqは、コンパイルされたテンプレートコードをソーステンプレートと同じ行に維持し、出力がきれいにフォーマットされるように、ホワイトスペースの長さに工夫を凝らしていて出力しています。

### 改行

Qiqは、タグの周りの改行を直感的に処理します。

* 出力されないQiqタグは、通常のPHPと同様に終了タグの直後に改行1行を出力します。

* Qiqのタグは、生であれエスケープされているものであれ、終了タグの直後の改行がひとつでもあれば使用されます。

たとえば、次のQiqコードは

```qiq
{{ if ($this->condition): }}
{{= "foo" }}
{{ endif; }}
```

このようなPHPコードにコンパイルされます。

```html+php
<?php if ($this->condition): ?>
<?= "foo" ?><?= PHP_EOL ?>
<?php endif ?>
```

エコーしないQiqタグは、チルダを開始タグに使用することで、単一の先頭改行を出力するようにすることができます。

このQiqのコードは

```qiq
{{~ foreach ($foo as $bar): }}
...
{{~ endforeach }}
```

このようなPHPコードにコンパイルされます。

```html+php
<?= PHP_EOL ?><?php foreach ($foo as $bar): ?>
...
<?= PHP_EOL ?><?php endforeach ?>
```

この機能は、ループ出力のコードでループの最初と最後に改行を入れたい場合に特に有用です。

### インデント

Qiqタグが出力されると、Qiqタグを開く前の先行するホワイトスペースに基づいてヘルパーの現在のインデントが自動的に設定されます。

このQiqコードは

```qiq
<ul>
    {{= $this->items(['foo', 'bar', 'baz']) }}
</ul>
```

このようなPHPコードにコンパイルされます。

```qiq
<ul>
    <?php \Qiq\Indent::set('    ') ?><?= $this->items(['foo', 'bar', 'baz']) ?>
</ul>
```
