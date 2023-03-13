# Form Helpers

All helpers automatically apply appropriate escaping. This means you can use
`{{= ... }}` to output them. If you use `{{h ... }}` et al., you will end up
double-escaping the output.

You can also address the helpers as methods on `$this` in PHP template code.

## Form Tag

Open a form like so:

```qiq
{{= form ([                         // (array) attributes
    'method' => 'post',
    'action' => '/hello',
]) }}
```

```html
<form method="post" action="/hello" enctype="multipart/form-data">
```

You can close a form just using `</form>`.

## Input Tags

### checkboxField

You can use a `checkboxField` as a generic input field helper, but you will
have to set the `checked` attribute yourself to mark it as checked or not.

Alternatively, if you specify the pseudo-attribute `_options`, greater
functionality becomes available:

- The `_options` specify one or more checkboxes as part of the field,
with their value when checked, and their corresponding label.

- If the `_options` have more than one element, then field name will be
  appended automatically with `[]` to make it an array.

- The `value` attribute will be matched against the `_options` and the correct
  checkboxes will be `checked` for you.

- The `_default` pseudo-attribute, when present, will produce a hidden input
field for the value when no checkboxes are checked.

```qiq
{{= checkboxField ([                // (array) attributes
    'name' => 'flags',
    'value' => 'bar',
    '_default' => '',
    '_options' => [
        'foo' => 'Foo Flag',
        'bar' => 'Bar Flag',
        'baz' => 'Baz Flag',
    ]
]) }}
```

```html
<input type="hidden" name="flags" value="" />
<label><input type="checkbox" name="flags[]" value="foo" /> Foo Flag</label>
<label><input type="checkbox" name="flags[]" value="bar" checked /> Bar Flag</label>
<label><input type="checkbox" name="flags[]" value="baz" /> Baz Flag</label>
```

### colorField

```qiq
{{= colorField ([                   // (array) attributes
    'name' => 'foo',
    'value' => 'bar',
]) }}
```

```html
<input type="color" name="foo" value="bar" />
```

### dateField

```qiq
{{= dateField ([                    // (array) attributes
    'name' => 'foo',
    'value' => 'bar',
]) }}
```

```html
<input type="date" name="foo" value="bar" />
```

### datetimeField

```qiq
{{= datetimeField ([                // (array) attributes
    'name' => 'foo',
    'value' => 'bar',
]) }}
```

```html
<input type="datetime" name="foo" value="bar" />
```

### datetimeLocalField

```qiq
{{= datetimeLocalField ([           // (array) attributes
    'name' => 'foo',
    'value' => 'bar',
]) }}
```

```html
<input type="datetime-local" name="foo" value="bar" />
```

### emailField

```qiq
{{= emailField ([                   // (array) attributes
    'name' => 'foo',
    'value' => 'bar',
]) }}
```

```html
<input type="email" name="foo" value="bar" />
```

### fileField

```qiq
{{= fileField ([                    // (array) attributes
    'name' => 'foo',
    'value' => 'bar',
]) }}
```

```html
<input type="file" name="foo" value="bar" />
```

### hiddenField

```qiq
{{= hiddenField ([                  // (array) attributes
    'name' => 'foo',
    'value' => 'bar',
]) }}
```

```html
<input type="hidden" name="foo" value="bar" />
```

### inputField

A generic input field; specify the `type` needed.

```qiq
{{= inputField ([                  // (array) attributes
    'type' => 'text',
    'name' => 'foo',
    'value' => 'bar',
    // ...
]) }}
```

```html
<input type="text" name="foo" value="bar" />
```

### monthField

```qiq
{{= monthField ([                   // (array) attributes
    'name' => 'foo',
    'value' => 'bar',
]) }}
```

```html
<input type="month" name="foo" value="bar" />
```

### numberField

```qiq
{{= numberField ([                  // (array) attributes
    'type' => 'number',
    'name' => 'foo',
    'value' => 'bar',
]) }}
```

```html
<input type="number" name="foo" value="bar" />
```

### passwordField

```qiq
{{= passwordField ([                // (array) attributes
    'name' => 'foo',
    'value' => 'bar',
]) }}
```

```html
<input type="password" name="foo" value="bar" />
```

### radioField

You can use a `radioField` as a generic input field helper, but you will
have to set the `checked` attribute yourself to mark it as checked or not.

Alternatively, if you specify the pseudo-attribute `_options`, greater
functionality becomes available:

- The `_options` specify one or more radio buttons as part of the field,
  with their value when checked, and their corresponding label.

- The `value` attribute will be matched against the `_options` and the correct
  checkboxes will be `checked` for you.

```qiq
{{= radioField ([                   // (array) attributes
    'name' => 'foo',
    'value' => 'baz',
    '_options' => [
        'bar' => 'Bar Label',
        'baz' => 'Baz Label,
        'dib' => 'Dib Label',
    ),
]) }}
```

```html
<label><input type="radio" name="foo" value="bar" /> Bar Label</label>
<label><input type="radio" name="foo" value="baz" checked /> Baz Label</label>
<label><input type="radio" name="foo" value="dib" /> Dib Label</label>
```

### rangeField

```qiq
{{= rangeField ([                   // (array) attributes
    'name' => 'foo',
    'value' => 'bar',
]) }}
```

```html
<input type="range" name="foo" value="bar" />
```

### searchField

```qiq
{{= searchField ([                  // (array) attributes
    'name' => 'foo',
    'value' => 'bar',
]) }}
```

```html
<input type="search" name="foo" value="bar" />
```

### select

Use the pseudo-attribute `_options` to describe the `<option>` tags.

The attribute `placeholder` is honored as a placeholder label when no
option is selected. The pseudo-attribute `_default` specifies the value of
the placeholder.

Using the attribute `'multiple' => true` will set up a multiple select, and
automatically add `[]` to the name if it is not already there.

```qiq
{{= select ([                       // (array) attributes
    'name' => 'foo',
    'value' => 'dib',
    'placeholder' => 'Please pick one',
    '_default' => '',
    '_options' => [
        'bar' => 'Bar Label',
        'baz' => 'Baz Label',
        'dib' => 'Dib Label',
        'zim' => 'Zim Label',
    ],
]) }}
```

```html
<select name="foo">
    <option value="" disabled>Please pick one</option>
    <option value="bar">Bar Label</option>
    <option value="baz">Baz Label</option>
    <option value="dib" selected>Dib Label</option>
    <option value="zim">Zim Label</option>
</select>
```

The helper also supports option groups. If an `_options` array value is itself
an array, the key for that element will be used as an `<optgroup>` label and
the array of values will be options under that group.

```qiq
{{= select ([
    'name' => 'foo',
    'value' => 'bar',
    '_options' => [
        'Group A' => [
            'bar' => 'Bar Label',
            'baz' => 'Baz Label',
        ],
        'Group B' => [
            'dib' => 'Dib Label',
            'zim' => 'Zim Label',
        ],
    ],
]) }}
```

```html
<select name="foo">
    <optgroup label="Group A">
        <option value="bar">Bar Label</option>
        <option value="baz">Baz Label</option>
    </optgroup>
    <optgroup label="Group B">
        <option value="dib" selected>Dib Label</option>
        <option value="zim">Zim Label</option>
    </optgroup>
</select>
```

### telField

```qiq
{{= telField([                      // (array) attributes
    'name' => 'foo',
    'value' => 'bar',
]) }}
```

```html
<input type="tel" name="foo" value="bar" />
```

### textField

```qiq
{{= textField ([                    // (array) attributes
    'name' => 'foo',
    'value' => 'bar',
]) }}
```

```html
<input type="text" name="foo" value="bar" />
```

### textarea

```qiq
{{= textarea ([                     // (array) attributes
    'name' => 'foo',
    'value' => 'bar',
]) }}
```

```html
<textarea name="foo">bar</textarea>
```

### timeField

```qiq
{{= timeField ([                    // (array) attributes
    'name' => 'foo',
    'value' => 'bar',
]) }}
```

```html
<input type="time" name="foo" value="bar" />
```

### urlField

```qiq
{{= urlField ([                      // (array) attributes
    'name' => 'foo',
    'value' => 'bar',
]) }}
```

```html
<input type="url" name="foo" value="bar" />
```

### weekField

```qiq
{{= weekField ([                    // (array) attributes
    'name' => 'foo',
    'value' => 'bar',
]) }}
```

```html
<input type="week" name="foo" value="bar" />
```

## Button Tags

Helpers for various button tags.

### button

```qiq
{{= button ([                       // (array) atttributes
    'name' => 'foo',
    'value' => 'bar',
]) }}
```

```html
<input type="button" name="foo" value="bar" />
```

### imageButton

```qiq
{{= imageButton ([                  // (array) atttributes
    'name' => 'foo',
    'src' => '/images/map.png',
]) }}
```

```html
<input type="image" name="foo" src="/images/map.png" />
```

### submitButton

```qiq
{{= submitButton ([                 // (array) atttributes
    'name' => 'foo',
    'value' => 'bar',
]) }}
```

```html
<input type="submit" name="foo" value="bar" />
```

### resetButton

```qiq
{{= resetButton ([                  // (array) attributes
    'name' => 'foo',
    'value' => 'bar',
]) }}
```

```html
<input type="reset" name="foo" value="bar" />
```

## Label Tag

A helper for `<label>` tags.

```qiq
{{= label (
    'Label For Field',              // (string) label text
    [                               // (array) optional attributes
        'for' => 'field'
    ]
) }}
```

```html
<label for="field">Label For Field</label>
```
