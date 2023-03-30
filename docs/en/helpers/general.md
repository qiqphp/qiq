# General Helpers

All helpers automatically apply appropriate escaping. This means you can use
`{{= ... }}` to output them. If you use `{{h ... }}` et al., you will end up
double-escaping the output.

You can also address the helpers as methods on `$this` in PHP template code.

Finally, many of these helpers accept a trailing variadic list of named
parameters as HTML tag attributes. This means you can add just about any
attribute as if it was a parameter on the helper method. Underscores in  the
parameter name will be converted to dashes; e.g., `foo_bar: 'baz'` will
become `foo-bar="baz"` in the returned helper output. For attributes that
cannot double as named parameters, use the `attr` array parameter; for
example:

```qiq
{{= anchor (
    'http://qiqphp.com',
    'Qiq Project',
    attr: [],                       // (array) key-value attributes
    id: 'qiq-link',                 // (...mixed) named parameter attributes
) }}
```

## anchor

Helper for `<a>` tags.

```qiq
{{= anchor (
    'http://qiqphp.com',            // (string) href
    'Qiq Project',                  // (string) text
    attr: [],                       // (array) key-value attributes
    id: 'qiq-link',                 // (...mixed) named parameter attributes
) }}
```

```html
<a href="http://qiqphp.com" id="qiq-link">Qiq for PHP</a>
```

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
    attr: [],                       // (array) key-value attributes
    id: 'test'                      // (...mixed) named parameter attributes
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
    attr: [],                       // (array) key-value attributes
    id: 'image-id'                  // (...mixed) named parameter attributes
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
{{= link (
    rel: 'prev',
    href: '/path/to/prev',
    attr: [],                       // (array) key-value attributes
    id: 'link-id'                   // (...mixed) named parameter attributes
) }}
```

```html
<link rel="prev" href="/path/to/prev" id="link-id" />
```

## linkStylesheet

Helper for a `<link>` stylesheet tag.

```qiq
{{= linkStylesheet (
    '/css/print.css',               // (string) the stylesheet href
    attr: [],                       // (array) key-value attributes
    media: 'print'                  // (...mixed) named parameter attributes
) }}
```

```html
<!-- if type is not specified, uses "text/css" -->
<link rel="stylesheet" href="/css/print.css" type="text/css" media="print" />
```

## meta

Helper for a `<meta>` tag.

```qiq
{{= meta (
    attr: [],                       // (array) key-value attributes
    charset: 'utf-8'                // (...mixed) named parameter attributes
) }}
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
    attr: [],                       // (array) key-value attributes
    id: 'foo-list'                  // (...mixed) named parameter attributes
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
    attr: [],                       // (array) key-value attributes
    async: true                     // (...mixed) named parameter attributes
) }}
```

```html
<!-- if type is not specified, uses "text/javascript" -->
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
    attr: [],                       // (array) key-value attributes
    id: 'foo-list'                  // (...mixed) named parameter attributes
) }}
```

```html
<ul id="foo-list">
    <li>foo</li>
    <li>bar</li>
    <li>baz</li>
</ul>
```
