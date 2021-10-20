# Template Syntax

Qiq templates are native PHP templates, with an optional `{{...}}` syntax for
concise escaping and helper use.

## Escaping and Output

Qiq will not echo any output itself, unless the opening tag starts with a
recognized escaping character:

- `{{ ... }}` will not echo at all by itself
- `{{= ... }}` will echo raw unescaped output
- `{{h ... }}` will echo escaped for HTML content
- `{{a ... }}` will echo escaped for HTML attributes
- `{{u ... }}` will echo escaped for URLs
- `{{c ... }}` will echo escaped for CSS
- `{{j ... }}` will echo escaped for JavaScript

The `{{a ... }}` tag offers the additional ability to output an array, using
the key as the attribute label and the value as the attribute value; multiple
attribute values will be space-separated. The following Qiq code ...

```qiq
<span {{a ['id' => 'foo', 'class' => ['bar', 'baz', 'dib']] }}>Text</span>
```

... will render as:

```html
<span id="foo" class="bar baz dib">Text</span>
```

You can echo just about any variable, literal, function, method, expression, or
constant, including the magic constants `__DIR__`, `__FILE__`, and `__LINE__`.

```qiq
{{h $this->foo }}
{{h $foo }}
{{h "foo" }}
{{h 1 + 2 }}
{{h __FILE__ }}
{{h PHP_EOL }}
{{h $person->firstName() }}
{{h time() }}
```

If you need to embed double curly braces literally, and not have them
interpreted as Qiq tags, put a backslash between the braces. The following Qiq
code ...

```qiq
{{ /* this is qiq code */ }}

{\{ this is not qiq code }\}
```

... will compile to this PHP code:

```html+php
<?php /* this is qiq code */ ?>

{{ this is not qiq code }}
```

## Control Structures

All control structures are written exactly as in PHP, using the
[alternative control structure syntax](https://php.net/control-structures.alternative-syntax)
when available, inside `{{...}}` Qiq tags.

For example, this Qiq code ...

```qiq
{{ foreach ($foo as $bar => $baz): }}
    {{ if ($baz === 0): }}
        {{= "First element!" }}
    {{ else: }}
        {{= "Not the first element." }}
    {{ endif }}
{{ endforeach }}
```
... is the same as this PHP code:

```html+php
<?php foreach ($foo as $bar => $baz): ?>
    <?php if ($bar === 0): ?>
        <?= "First element!" ?><?= PHP_EOL ?>
    <?php else: ?>
        <?= "Not the first element." ?><?= PHP_EOL ?>
    <?php endif ?>
<?php endforeach ?>
```

Qiq syntax recognizes most PHP control structures:

- `break`
- `continue`
- `declare`
- `for`, `endfor`
- `foreach`, `endforeach`
- `goto`
- `if`, `elseif`, `else`, `endif`
- `include`, `include_once`
- `require`, `require_once`
- `while`, `endwhile`

Qiq does not recognize `else if`, `switch`, `case`, or `match`; for these, you
can always fall back to plain PHP.

## Reserved Words

Qiq recognizes the following reserved words.

- `empty`
- `isset`
- `list`
- `namespace`
- `use`

## Helpers

Any opening keyword Qiq does not recognize is treated as a template helper
method. The following Qiq syntax ...

```qiq
{{= label ("Street Address", ['for' => 'street']) }}
{{= textField ([
    'name' => 'street',
    'value' => $this->street,
]) }}
```

... is equivalent to this PHP code with Qiq helpers:

```html+php
<?= $this->label("Street Address", ['for' => 'street']) ?>
<?= $this->textField([
    'name' => 'street',
    'value' => $this->street,
]) ?>
```

## Other PHP Code

Qiq treats all other code inside `{{...}}` tags as plain old PHP code. For
example, this Qiq syntax ...

```qiq
{{ $title = "Prefix: " . $this->title . " (Suffix)" }}
<title>{{h $title}}</title>
```

... is equivalent to this PHP code with Qiq helpers:

```html+php
<?php $title = "Prefix: " . $this->title . " (Suffix)" ?>
<title><?= $this->h($title) ?></title>
```

## Whitespace

Qiq goes to some lengths to help control whitespace in output, to keep the
compiled template code on the same lines as in the source template, and to
help make sure the output is formatted nicely.

### Newlines

Qiq offers intuitive handling of newlines around tags:

- Non-echoing Qiq tags, just as with plain PHP, will **consume** any single
  trailing newline immediately after the closing tag.

- Echoing Qiq tags, whether raw or escaped, will **honor** any single trailing
  newline immediately after the closing tag.

For example, this Qiq code ...

```qiq
{{ if ($this->condition): }}
{{= "foo" }}
{{ endif; }}
```

... compiles to this PHP code:

```html+php
<?php if ($this->condition): ?>
<?= "foo" ?><?= PHP_EOL ?>
<?php endif ?>
```

Non-echoing Qiq can be made to echo a single **leading** newline by using a tilde
with the opening tag. This Qiq code ...

```qiq
{{~ foreach ($foo as $bar): }}
...
{{~ endforeach }}
```

... compiles to this PHP code:

```html+php
<?= PHP_EOL ?><?php foreach ($foo as $bar): ?>
...
<?= PHP_EOL ?><?php endforeach ?>
```

This is especially useful with looping output code, where you want to honor
newlines at the very beginning and very end of the loop.

### Indenting

Echoing Qiq tags will automatically set the current indent for helpers based on
the leading whitespace before the opening Qiq tag.

This Qiq code ...

```qiq
<ul>
    {{= $this->items(['foo', 'bar', 'baz']) }}
</ul>
```

... compiles to this PHP code:

```html+php
<ul>
    <?php \Qiq\Indent::set('    ') ?><?= $this->items(['foo', 'bar', 'baz']) ?>
</ul>
```
