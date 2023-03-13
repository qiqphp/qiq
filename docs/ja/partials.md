### パーシャル

1つのテンプレートを複数のパーツに分割したい場合があります。このような"部分的な"テンプレートは、メインテンプレートのコードで`render()`メソッドを使用してレンダリングすることができます。

レンダリングの際に、部分テンプレートのローカルスコープに抽出する変数の配列を渡すことができます。(メインの`$this`Template変数は、それに関係なく常に使用可能です。)

例えば、`list`のパーシャルテンプレートは次のようなものです。

```html+php
<ul>
    {{ foreach ($items as $item): }}
    <li>{{h $item}}</li>
    {{ endforeach }}
</ul>
```

そして、メインの`browse`テンプレートで、部分的な`list`をレンダリングすることができます。

```html+php
<p>My List</p>
{{= render ('list', [
    'items' => 'foo', 'bar', 'baz']
]) }}
```

レンダリングされたHTMLは、次のようになります。

```html+php
<p>My List</p>
<ul>
    <li>foo</li>
    <li>bar</li>
    <li>baz</li>
</ul>
```
