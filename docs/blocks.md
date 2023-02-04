# Blocks

<p style="font-size: 90%;"><em>Blocks and sections serve similar purposes,
but have different implementations and features.</em></p>

* * *

Blocks are similar to partials, except that they are captured inline for later
use. In general, blocks are used by view templates to capture output for
layout templates.

Alternatively, blocks may be used by child templates to capture output for
parent templates (cf.  the [inheritance](./inheritance.md) documentation).

For example, a layout template file might define a block for local navigation,
adding some default content for that block:

```html+php
<html>
<head>
<title>Blocks Example</title>
</head>
<body>
<div id="local-nav">

{{ setBlock ('local-nav') }}
    <p><a href="/foo">Foo</a></p><!-- layout -->
{{= getBlock () ~}}

</div>
</body>
</html>
```

The `setBlock()` method opens the specified block; `getBlock()` closes the
block and echoes the captured output between the two method calls.

Then, a view file might redefine that block:

```html+php
{{ setBlock ('local-nav') }}
    <p><a href="/bar">Bar</a></p><!-- view, above parent-->
    {{ parentBlock() }}
    <p><a href="/baz">Baz</a></p><!-- view, below parent -->
{{ endBlock () }}
```

Note the use of `parentBlock()` above. This method is a placeholder for the
parent block content, allowing you to prepend and append that content if you
like. (If you do not call `parentBlock()`, the `setBlock()` call will
completely override the parent block content.)

Finally, rendering the combined view and layout ...

```php
$template = Template::new(...);
$template->setLayout('layout');
$template->setView('view');
$output = $template();
```

... will generate something like the following output:

```html
<html>
<head>
<title>Blocks Example</title>
</head>
<body>
<div id="local-nav">
    <p><a href="/bar">Bar</a></p><!-- view, above parent -->
    <p><a href="/foo">Foo</a></p><!-- layout -->
    <p><a href="/baz">Baz</a></p><!-- view, below parent -->
</div>
</body>
</html>
```
