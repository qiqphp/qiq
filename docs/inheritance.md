# Inheritance

Whereas you can wrap an inner "view" template with an outer "layout" template, you can also "extend" one template with another template. The differences are subtle but important.

Here is an example of extending a template. First, a "parent" template, composed of a series of blocks:

```html+qiq
<!DOCTYPE html>
<html lang="en">
<head>
{{setBlock ('head_title') }}{{= getBlock () }}
{{setBlock ('head_meta') }}{{= getBlock () }}
{{setBlock ('head_links') }}{{= getBlock () }}
{{setBlock ('head_styles') }}
    <link rel="stylesheet" href="/theme/basic.css" type="text/css" media="screen" />
{{= getBlock () }}
{{setBlock ('head_scripts') }}{{= getBlock () }}
</head>
<body>
{{ setBlock ('body_header') }}{{= getBlock () }}
{{ setBlock ('body_content') }}{{= getBlock () }}
{{ setBlock ('body_footer') }}{{= getBlock () }}
</body>
</html>
```

The above code defines a series of blocks via `setBlock()`, then displays the *final* block contents via `getBlock()`.  Any content between `setBlock()` and `getBlock()` is used as the default content for that block; the final block contents will be determined by any overrides in the child templates.

Next, a "child" template that extends the "parent" template; note how it `extends()` the "parent" template, and overrides or modifieds content from the parent blocks:

```html+qiq
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
$output = $tpl->__invoke('child');
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

A similar approach is possible using sections with views and layouts; however, only one layer of extension is possible that way (i.e., from the view to the layout). With `extends()`, any number of layers is possible.

A child block may insert its parent block content using a `parentBlock()` call. This allows a child block to prepend or append the parent block content. Without a `parentBlock()` call, `setBlock()` will completely override the parent block content.

Templates are rendered from the latest child to the earliest parent. However, blocks are processed in reverse order, from earliest parent to latest child, so that child block overrides and `parentBlock()` calls are honored appropriately.

Both views and layouts may use `extends()`. That is, an inner view may extend one series of templates, and an outer layout may extend a different series of templates.

Blocks are shared between both views and layouts. That is, layout blocks can be referred to by views.

Finally, note that `getContent()` may not work as expected when extending templates. Any content *not* in a block will be overwritten with each successive `extends()` call, so that only content from the last rendered template will be captured.
