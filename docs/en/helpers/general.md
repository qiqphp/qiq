# General Helpers

All helpers automatically apply appropriate escaping. This means you can use
`{{= ... }}` to output them. If you use `{{h ... }}` et al., you will end up
double-escaping the output.

You can also address the helpers as methods on `$this` in PHP template code.

## anchor

Helper for `<a>` tags.

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

To output the anchor text without escaping, use the pseudo-attribute `_raw`:

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

(The href and attributes will still be escaped properly.)

## base

Helper for `<base>` tags.

```qiq
{{= base (
    '/base'                         // (string) href
) }}
```

```html
<base href="/base" />
```

## dl

Helper for `<dl>` tags with `<dt>`/`<dd>` items.

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

Helper for `<img>` tags.

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

Helper for a series of `<li>` tags.

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

Helper for a `<link>` tag.

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

Helper for a `<link>` stylesheet tag.

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

Helper for a `<meta>` tag.

```qiq
{{= meta ([                         // (array) attributes
    'charset' => 'utf-8'
]) }}
```

```html
<meta charset="utf-8">
```

## metaHttp

Helper for a `<meta http-equiv>` tag.

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

Helper for a `<meta name>` tag.

```qiq
{{= metaName (
    'author',                       // (string) name attribute
    'Qiq for PHP'                   // (string) content attribute
) }}
```

```html
<meta name="author" content="Qiq for PHP">
```

## ol

Helper for `<ol>` tags with `<li>` items.

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

Helper for a `<script>` tag.

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

Helper for `<ul>` tags with `<li>` items.

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
