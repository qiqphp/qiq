### Partials

Sometimes you will want to split a single template file into multiple files.
You can render these "partial" template pieces using the `render()` method in
your main template code.

When rendering, you can pass an array of variables to be extracted into the
local scope of the partial template. (All shared variables assigned to
the _Template_ variable will also be available.)

For example, a `list` partial template might look like this:

```html+php
<ul>
    {{ foreach ($items as $item): }}
    <li>{{h $item}}</li>
    {{ endforeach }}
</ul>
```

Then in a main `browse` template, you can render the partial `list`:

```html+php
<p>My List</p>
{{= render ('./list', [
    'items' => ['foo', 'bar', 'baz']
]) }}
```

The rendered HTML will look something like this:

```html+php
<p>My List</p>
<ul>
    <li>foo</li>
    <li>bar</li>
    <li>baz</li>
</ul>
```
