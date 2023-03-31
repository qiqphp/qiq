# Layouts

To wrap a main "inner" view template with an "outer" layout template, call
`setLayout()` to pick a second "outer" template for the second step. (If no
layout is set, the second step will not be executed.)

Let's say you already have a view template called `browse`. You might then have
a layout template called `default` to wrap the view. The `default.php` layout
template could look like this:

```html+php
<html>
<head>
    <title>My Site</title>
</head>
<body>
{{= getContent() }}
</body>
</html>
```

You can then set the view and layout templates on the _Template_ object and
invoke it:

```php
$template->setView('browse');
$template->setLayout('default');
$output = $template();
```

The output from the inner view template is automatically retained and becomes
available via the `getContent()` method on the _Template_ object. The layout
template then calls `getContent()` to place the inner view results in the outer
layout template.

> **Note:**
>
> You can also call `setLayout()` from inside the view template, allowing you
> to pick a layout as part of the view logic.

The view template and the layout template both execute inside the
same _Template_ object. This means:

- All variables assigned to the view are shared with the layout.

- All helpers are shared between the view and the layout.

This sharing situation allows the view to modify data and helpers before the
layout is executed.
