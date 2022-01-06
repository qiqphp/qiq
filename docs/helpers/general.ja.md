# 一般的なヘルパー

すべてのヘルパーは自動的に適切なエスケープを適用します。これはつまり、`{{= ... }}`を使って出力することができます。もし、`{{h ... }}`などを使うと、二重にエスケープして出力してしまいます。

PHPのテンプレートコードで、ヘルパーを`$this`のメソッドとして指定することもできます。

## anchor

`<a>`タグ用のヘルパーです。

```qiq
{{= anchor (
    'http://qiqphp.com',            // (string) href
    'Qiq Project',                  // (string) text
    [                               // (array) optional attributes
        'id' => 'qiq-link'
    ]
) }}
```

```html
<a href="http://qiqphp.com" id="qiq-link">Qiq for PHP</a>
```

アンカーテキストをエスケープせずに出力するには、擬似属性`_raw`を使用します。

```qiq
{{= anchor (
    'http://qiqphp.com',            // (string) href
    '<em>qiq Project</em>',         // (string) text
    [                               // (array) optional attributes

        'id' => 'qiq-link'
        '_raw' => true
    ]
) }}
```

```html
<a href="http://qiqphp.com" id="qiq-link"><em>Qiq for PHP</em></a>
```

(hrefと属性はちゃんとエスケープされます)

## base

`<base>`タグのヘルパーです。

```qiq
{{= base (
    '/base'                         // (string) href
) }}
```

```html
<base href="/base" />
```

## dl

`<dl>`タグに`<dt>`/`<dd>`アイテムを指定するためのヘルパーです。

```qiq
{{= dl (
    [                               // (array) dt keys and dd values
        'foo' => 'Foo Def',
        'bar' => [
            'Bar Def A',
            'Bar Def B',
            'Bar Def C',
        ],
        'baz' => 'Baz Def',
    ],
    [                               // (array) optional attributes
        'id' => 'test'
    ],
) }}
```

```html
<dl id="test">
    <dt>foo</dt>
        <dd>Foo Def</dd>
    <dt>bar</dt>
        <dd>Bar Def A</dd>
        <dd>Bar Def B</dd>
        <dd>Bar Def C</dd>
    <dt>baz</dt>
        <dd>Baz Def</dd>
</dl>
```

## image

`<img>`タグのヘルパーです。

```qiq
{{= image (
    '/images/hello.jpg',            // (string) image href src
    [                               // (array) optional attributes
        'id' => 'image-id'
    ]
) }}
```

```html
<!-- if alt is not specified, uses the basename of the image href -->
<img src="/images/hello.jpg" alt="hello" id="image-id" />
```

## items

一連の`<li>`タグのためのヘルパーです。

```qiq
{{= items ([                        // (array) list items
    'foo',
    'bar',
    'baz'
]) }}
```

```html
<li>foo</li>
<li>bar</li>
<li>baz</li>
```

## link

`<link>`タグのヘルパーです。

```qiq
{{= link ([                         // (array) attributes
    'rel' => 'prev',
    'href' => '/path/to/prev',
]) }}
```

```html
<link rel="prev" href="/path/to/prev" />
```

## linkStylesheet

`<link>`スタイルシートタグのためのヘルパー。

```qiq
{{= linkStylesheet (
    '/css/print.css',               // (string) the stylesheet href
    [                               // (array) optional attributes
        'media' => 'print',
    ]
) }}
```

```html
<link rel="stylesheet" href="/css/print.css" type="text/css" media="print" />
```

## meta

`<meta>`タグのヘルパーです。

```qiq
{{= meta ([                         // (array) attributes
    'charset' => 'utf-8'
]) }}
```

```html
<meta charset="utf-8">
```

## metaHttp

`<meta http-equiv>`タグ用のヘルパーです。

```qiq
{{= metaHttp (
    'Location',                     // (string) http-equiv attribute
    '/redirect/to/here'             // (string) content attribute
) }}
```

```html
<meta http-equiv="Location" content="/redirect/to/here">
```

## metaName

`<meta name>`タグのヘルパーです。

```qiq
{{= metaHttp (
    'author',                       // (string) name attribute
    'Qiq for PHP'                   // (string) content attribute
) }}
```

```html
<meta name="author" content="Qiq for PHP">
```

## ol

`<li>`を持つ`<ol>`タグのためのヘルパーです。

```qiq
{{= ol (
    [                               // (array) list items
        'foo',
        'bar',
        'baz'
    ],
    [                               // (array) optional attributes
        'id' => 'foo-list'
    ]
) }}
```

```html
<ol id="foo-list">
    <li>foo</li>
    <li>bar</li>
    <li>baz</li>
</ol>
```

## script

`<script>`タグのヘルパーです。

```qiq
{{= script (
    '/js/functions.js',             // (string) src attribute
    [                               // (array) other attributes
        'async' => true
    ]
) }}
```

```html
<script src="/js/functions.js" type="text/javascript" async></script>
```

## ul

`<li>`を持つ`<ul>`タグのためのヘルパーです。

```qiq
{{= ul (
    [                               // (array) list items
        'foo',
        'bar',
        'baz'
    ],
    [                               // (array) optional attributes
        'id' => 'foo-list'
    ]
) }}
```

```html
<ul id="foo-list">
    <li>foo</li>
    <li>bar</li>
    <li>baz</li>
</ul>
```
