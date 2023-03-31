# Form Helpers

All helpers automatically apply appropriate escaping. This means you can use
`{{= ... }}` to output them. If you use `{{h ... }}` et al., you will end up
double-escaping the output.

You can also address the helpers as methods on `$this` in PHP template code.

Finally, many of these helpers accept a trailing variadic list of named
parameters as HTML tag attributes. This means you can add just about any
attribute as if it was a parameter on the helper method. Underscores in  the
parameter name will be converted to dashes; e.g., `foo_bar: 'baz'` will
become `foo-bar="baz"` in the returned helper output. For attributes that
cannot double as named parameters, use the `attr` array parameter.

## Form Tag

Open a form like so:

```qiq
{{= form (
    action: '/hello',
    attr: [],               // (array) optional key-value attributes
    id: 'form-id'           // (...mixed) optional named parameter attributes
) }}
```

```html
<!-- defaults to method="post" action="" enctype="multipart/form-data" -->
<form method="post" action="/hello" enctype="multipart/form-data" id="form-id">
```

You can close a form just using `</form>`.

## Input Tags

### checkboxField

```qiq
{{= checkboxField (
    name: 'flag',
    value: 'foo',
    checked: true,
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="checkbox" name="flag" value="foo" checked />
```

### checkboxFields

The `checkboxFields` helper can be used for one or more checkboxes at a time,
and has greater functionality than the `checkboxField` helper:

- The `options` array specifies one or more checkboxes as part of the
  field, with each value when checked, and the corresponding label.

- If the `options` have more than one element, then field name will be
  appended automatically with `[]` to make it an array.

- The `value` attribute will be matched against the `options` and the correct
  checkboxes will be `checked` for you.

- The `default` parameter, when non-null, will produce a hidden input field
  for the value when no checkboxes are checked.

```qiq
{{= checkboxFields (
    name: 'flags',
    value: 'bar',
    default: '',
    options: [
        'foo' => 'Foo Flag',
        'bar' => 'Bar Flag',
        'baz' => 'Baz Flag',
    ],
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="hidden" name="flags" value="" />
<label><input type="checkbox" name="flags[]" value="foo" /> Foo Flag</label>
<label><input type="checkbox" name="flags[]" value="bar" checked /> Bar Flag</label>
<label><input type="checkbox" name="flags[]" value="baz" /> Baz Flag</label>
```

### colorField

```qiq
{{= colorField (
    name: 'foo',
    value: 'bar',
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="color" name="foo" value="bar" />
```

### dateField

```qiq
{{= dateField (
    name: 'foo',
    value: 'bar',
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="date" name="foo" value="bar" />
```

### datetimeField

```qiq
{{= datetimeField (
    name: 'foo',
    value: 'bar',
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="datetime" name="foo" value="bar" />
```

### datetimeLocalField

```qiq
{{= datetimeLocalField (
    name: 'foo',
    value: 'bar',
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="datetime-local" name="foo" value="bar" />
```

### emailField

```qiq
{{= emailField (
    name: 'foo',
    value: 'bar',
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="email" name="foo" value="bar" />
```

### fileField

```qiq
{{= fileField (
    name: 'foo',
    value: 'bar',
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="file" name="foo" value="bar" />
```

### hiddenField

```qiq
{{= hiddenField (
    name: 'foo',
    value: 'bar',
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="hidden" name="foo" value="bar" />
```

### inputField

A generic input field; specify the `type` needed.

```qiq
{{= inputField (
    type: 'text',
    name: 'foo',
    value: 'bar',
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="text" name="foo" value="bar" />
```

### monthField

```qiq
{{= monthField (
    name: 'foo',
    value: 'bar',
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="month" name="foo" value="bar" />
```

### numberField

```qiq
{{= numberField (
    name: 'foo',
    value: 'bar',
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="number" name="foo" value="bar" />
```

### passwordField

```qiq
{{= passwordField (
    name: 'foo',
    value: 'bar',
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="password" name="foo" value="bar" />
```

### radioField

```qiq
{{= radioField (
    name: 'foo',
    value: 'baz',
    checked: true,
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="radio" name="foo" value="baz" checked />
```

### radioFields

The `radioFields` helper has greater functionality than the `radioField`
helper:

- The `options` parameter specfies one or more radio buttons as part of the
  field, with their value when checked, and their corresponding label.

- The `value` parameter will be matched against the `options` and the correct
  radio button will be `checked` for you.

```qiq
{{= radioFields (
    name: 'foo',
    value: 'baz',
    options: [
        'bar' => 'Bar Label',
        'baz' => 'Baz Label,
        'dib' => 'Dib Label',
    ),
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<label><input type="radio" name="foo" value="bar" /> Bar Label</label>
<label><input type="radio" name="foo" value="baz" checked /> Baz Label</label>
<label><input type="radio" name="foo" value="dib" /> Dib Label</label>
```

### rangeField

```qiq
{{= rangeField (
    name: 'foo',
    value: 'bar',
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="range" name="foo" value="bar" />
```

### searchField

```qiq
{{= searchField (
    name: 'foo',
    value: 'bar',
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="search" name="foo" value="bar" />
```

### select

Use the `options` parameter to describe the `<option>` tags.

The `placeholder` parameter is honored as a placeholder label when no option
is selected. The `default` parameter, when non-null, specifies the value of
that placeholder.

Use `multiple: true` to set up a multiple select; this will automatically add
`[]` to the name if it is not already there.

```qiq
{{= select (
    name: 'foo',
    value: 'dib',
    placeholder: 'Please pick one',
    default: '',
    options: [
        'bar' => 'Bar Label',
        'baz' => 'Baz Label',
        'dib' => 'Dib Label',
        'zim' => 'Zim Label',
    ],
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
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

The helper also supports option groups. If an `options` array value is itself
an array, the key for that element will be used as an `<optgroup>` label and
the array of values will be options under that group.

```qiq
{{= select (
    name: 'foo',
    value: 'bar',
    options: => [
        'Group A' => [
            'bar' => 'Bar Label',
            'baz' => 'Baz Label',
        ],
        'Group B' => [
            'dib' => 'Dib Label',
            'zim' => 'Zim Label',
        ],
    ],
) }}
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
{{= telField(
    name: 'foo',
    value: 'bar',
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="tel" name="foo" value="bar" />
```

### textField

```qiq
{{= textField (
    name: 'foo',
    value: 'bar',
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="text" name="foo" value="bar" />
```

### textarea

```qiq
{{= textarea (
    name: 'foo',
    value: 'bar',
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<textarea name="foo">bar</textarea>
```

### timeField

```qiq
{{= timeField (
    name: 'foo',
    value: 'bar',
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="time" name="foo" value="bar" />
```

### urlField

```qiq
{{= urlField (
    name: 'foo',
    value: 'bar',
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="url" name="foo" value="bar" />
```

### weekField

```qiq
{{= weekField (
    name: 'foo',
    value: 'bar',
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="week" name="foo" value="bar" />
```

## Button Tags

Helpers for various button tags.

### button

```qiq
{{= button (
    name: 'foo',
    value: 'bar',
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="button" name="foo" value="bar" />
```

### imageButton

```qiq
{{= imageButton (
    name: 'foo',
    src: '/images/map.png',
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="image" name="foo" src="/images/map.png" />
```

### submitButton

```qiq
{{= submitButton (
    name: 'foo',
    value: 'bar',
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="submit" name="foo" value="bar" />
```

### resetButton

```qiq
{{= resetButton (
    name: 'foo',
    value: 'bar',
    attr: [],               // (array) optional key-value attributes
    ...                     // (...mixed) optional named parameter attributes
) }}
```

```html
<input type="reset" name="foo" value="bar" />
```

## Label Tag

A helper for `<label>` tags.

```qiq
{{= label (
    'Label For Field',      // (string) label text
    attr: [],               // (array) optional key-value attributes
    for: 'field'            // (...mixed) optional named parameter attributes
) }}
```

```html
<label for="field">Label For Field</label>
```
