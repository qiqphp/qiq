# セクション

セクションはパーシャルと似ていますが、後で使用するためにインラインでキャプチャされる点が異なります。一般的には、レイアウトテンプレートの出力をキャプチャするためにビューテンプレートで使用されます。

例えば、ビューテンプレートの出力を名前付きセクションにキャプチャーすることができます。

```html+php
{{ setSection ('local-nav') }}
    <!-- ... local navigation items ... -->
{{ endSection () }}
```

そして、その出力をレイアウトテンプレートで使用します。

```html+php
<div id="local-nav">
    {{= getSection ('local-nav') }}
</div>
```

`setSection()`を使用すると、そのセクションの以前のコンテンツはすべて上書きされます。`preSection()`で前置詞を、`addSection()`で後置詞を指定し、それぞれをセクションに追加します。

```html+php
{{ preSection ('local-nav')}}
<!-- add items to the top of the nav -->
{{ endSection() }}

{{ addSection ('local-nav')}}
<!-- add items to the end of the nav -->
{{ endSection() }}
```

セクションが存在するかどうかは、`hasSection()`を使って確認できます。

```html+php
{{ if ($this->hasSection('local-nav')): }}
<div id="local-nav">
    {{= getSection ('local-nav') }}
</div>
{{ endif }}
```
