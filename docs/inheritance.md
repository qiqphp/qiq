# Inheritance

Whereas you can wrap an inner "view" template with an outer "layout" template,
you can also "extend" one template with another template. The differences are
subtle but important.

Here is an example of template inheritance. First, a "parent" template,
composed of a series of blocks:

```html+php
<!DOCTYPE html>
<html lang="en">
<head>
{{ setBlock ('head_title') }}{{= getBlock () ~}}
{{ setBlock ('head_meta') }}{{= getBlock () ~}}
{{ setBlock ('head_links') }}{{= getBlock () ~}}
{{ setBlock ('head_styles') }}
    <link rel="stylesheet" href="/theme/basic.css" type="text/css" media="screen" />
{{= getBlock () ~}}
{{ setBlock ('head_scripts') }}{{= getBlock () ~}}
</head>
<body>
{{ setBlock ('body_header') }}{{= getBlock () ~}}
{{ setBlock ('body_content') }}{{= getBlock () ~}}
{{ setBlock ('body_footer') }}{{= getBlock () ~}}
</body>
</html>
```

The above code defines a series of blocks via `setBlock()`, then displays
the *final* block contents via `getBlock()`. (Note the use of the closing tag
`~}}` to consume the newline after the tag, which condenses blank lines in
the output.)

Next, a "child" template that extends the "parent" template. Note how it
`extends()` the "parent" template, and overrides or modifies content from the
parent blocks:

```html+php
{{ extends ('parent') }}

{{ setBlock ('head_title') }}
    <title>
        My Extended Page
    </title>
{{ endBlock () }}

{{ setBlock ('head_meta') }}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
{{ endBlock () }}

{{ setBlock ('head_styles') }}
{{ parentBlock () }}
    <link rel="stylesheet" href="/theme/custom.css" type="text/css" media="screen" />
{{ endBlock () }}

{{ setBlock ('body_content') }}
    <p>The main content for my extended page.</p>
{{ endBlock () }}
```

Finally, when you render the "child" template ...

```php
$output = $tpl('child');
```

... the output will look something like this:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        My Extended Page
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/theme/basic.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="/theme/custom.css" type="text/css" media="screen" />
</head>
<body>
    <p>The main content for my extended page.</p>
</body>
</html>
```

A similar approach is possible with views and layouts. However, only one layer
of extension is possible that way (i.e., from the view to the layout). With
`extends()`, any number of layers is possible.

Both views and layouts may use `extends()`. That is, an inner view may extend
one series of templates, and an outer layout may extend a different series of
templates.

Blocks are shared between both views and layouts. Layout blocks can be
referred to by views, and vice versa.

Finally, `getContent()` may not work as expected when extending templates. Any
content *not* in a block will be overwritten with each successive call to
`extends()`, so that only content from the last rendered template will be
captured. As such, it is probably best to capture the "main" content of a
view inside a block of its own, as in the above example, rather than using
`getContent()`.
