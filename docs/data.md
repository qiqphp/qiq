# Template Data

To assign a data collection to the _Template_, use the `setData()` method and
pass either an array or a `stdClass` object.

```php
$tpl->setData([
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
$tpl->addData([
    'title' => 'My Items',
]);
```

You can then use the data elements as if they are properties of `$this` inside
the template:

```html+php
<p>{{h $this->title}}</p>
<ul>
    {{ foreach ($this->items as $id => $name): }}
    <li id="{{a $id}}">{{h $name }}</li>
</ul>
```
