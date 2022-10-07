# フォームヘルパー

すべてのヘルパーは自動的に適切なエスケープを適用します。これはつまり、`{{= ... }}`を使って出力することができます。もし、`{{h ... }}`などを使うと、二重にエスケープして出力してしまいます。

PHPのテンプレートコードで、ヘルパーを`$this`のメソッドとして指定することもできます。

## フォームタグ

このようにフォームを開きます。

```qiq
{{= form ([                         // (array) attributes
    'method' => 'post',
    'action' => '/hello',
]) }}
```

```html
<form method="post" action="/hello" enctype="multipart/form-data">
```

フォームを閉じるには、`</form>`を使用します。

## 入力タグ

### checkboxField

`checkboxField`は汎用の入力フィールドヘルパーとして使用できますが、チェック済みかどうかをマークするために、自分で`checked`属性を設定する必要があります。

代わりに、擬似属性`_options`を指定すると、より高機能なものが利用できるようになります。

- `_options`は、フィールドの一部として1つ以上のチェックボックスを指定し、チェックされたときの値と、それに対応するラベルを指定します。

- `_options`が複数の要素を持つ場合、フィールド名には自動的に`[]`が付加され、配列となります。

- `value`属性は`_options`と照合され、正しいチェックボックスが`checked`されるようになります。

- `default`疑似属性が存在する場合、チェックボックスがチェックされていないとき、値のための隠された入力フィールドを生成します。

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

一般的な入力フィールド。必要な`type`を指定する。

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

`radioField`を汎用の入力フィールドヘルパーとして使用することができますが、チェック済みかどうかをマークするために、自分で`checked`属性を設定する必要があります。

また、擬似属性 `_options`を指定することで、より高機能なものが利用できます。

- `_options`は、フィールドの一部として1つまたは複数のラジオボタンを指定し、チェックしたときの値と、それに対応するラベルを指定します。

- `value`属性が`_options`とマッチングされ、適切なチェックボックスが`checked`されるようになります。

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

`<option>`タグの記述には、擬似属性`_options`を使用します。

属性`placeholder`は、オプションが選択されていない場合、プレースホルダー・ラベルとして尊重されます。擬似属性`_default`は、プレースホルダーの値を指定します。

属性`'multiple' => true`を使用すると、複数選択が設定され、名前に`[]`がない場合は自動的に追加されます。


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

このヘルパーはオプショングループもサポートしています。もし`_options`配列の値そのものが配列なら、その要素のキーが `<optgroup>`ラベルとして使われ、値の配列は、そのグループのオプションとなります。

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

各種ボタンタグのヘルパーです。

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

`<label>`タグ用のヘルパーです。

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
