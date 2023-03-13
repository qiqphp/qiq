# Template Data

## Assigning Variables

To assign a data collection to the _Template_, use the `setData()` method and
pass either an array or a `stdClass` object.

```php
$template->setData([
    'items' => [
        [
            'id' => '1',
            'name' => 'Foo',
        ],
        [
            'id' => '2',
            'name' => 'Bar',
        ],
        [
            'id' => '3',
            'name' => 'Baz',
        ],
    )
]);
```

The `setData()` method will overwrite all existing data in the _Template_
object.

The `addData()` method, on the other hand, will merge any `iterable` with the
existing _Template_ data.

```php
$template->addData([
    'title' => 'My Items',
]);
```

## Using Assigned Variables

You can then use the assigned data as variables within the template file:

```html+php
<p>{{h $title}}</p>
<ul>
    {{ foreach ($items as $id => $name): }}
    <li id="{{a $id}}">{{h $name }}</li>
</ul>
```

If you want to get a copy of all assigned data as an array, use `getData
()`. Any changes you make to the copy will be **to the copy** and not to the
data actually assigned to the _Template_.

Alternatively, if you want to get a *reference* to the array of all assigned
data, use `&refData()`. Any changes you make to the reference will be to the
actual assigned data.

## Variable Scope

Data assigned to the _Template_ object with `setData()` or `addData()` is
shared in every template file by reference. Modifications to an assigned
variable in one template file will be shared with all other template files.
In the above example, `$title` and `$items` are available in every template
file. Changes to `$title` or `$items` will be shared through other template
files.

However, variables created inside a template file are local to that template
file only. They are not shared with any other template. In the above example,
`$id` and `$name` (because they are created inside the template file) are
local to that template file only, and changes to them will not be seen
anywhere else.

When designing template files, be careful not to accidentally overwrite
assigned variables with local variables. The local values will be shared with
all other templates, which may not be what you want.

Finally, changes to assigned variables via `setData()`, `addData()`, and
`&refData()` from **inside** a template file **will not** be honored within
that template file, only in the next one rendered. This is because the
assigned variables have already been extracted into the current scope; only
the next templates to be rendered will see the modified values.
