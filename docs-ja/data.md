# テンプレートデータ

`setData()`メソッドに配列または`stdClass`オブジェクトを渡してTemplateにデータコレクションをアサインします。

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

`setData()`メソッドは、Templateオブジェクトの既存のデータをすべて上書きします。

一方、`addData()`メソッドは、任意の`iterable`データを既存のTemplateデータにマージします。

```php
$tpl->addData([
    'title' => 'My Items',
]);
```

そうすると、テンプレート内でデータ要素を`$this`のプロパティのように使うことができます。

```html+php
<p>{{h $this->title}}</p>
<ul>
    {{ foreach ($this->items as $id => $name): }}
    <li id="{{a $id}}">{{h $name }}</li>
</ul>
```
