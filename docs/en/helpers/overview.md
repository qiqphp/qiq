# Overview

Helpers are class methods that generate output for you. You can address them
as methods on `$this` in PHP template code, or by just the helper name when
using Qiq syntax.

PHP syntax:

```html+php
<?= $this->anchor('http://qiqphp.com', 'Qiq for PHP') ?>
```

Qiq syntax:

```qiq
{{= anchor ('http://qiqphp.com', 'Qiq for PHP') }}
```

Both generate this HTML:

```html
<a href="http://qiqphp.com">Qiq for PHP</a>
```

Qiq comes with a comprehensive set of helpers for [general use](./general.md),
and for [building forms](./forms.md). You can also create your own
[custom helpers](./custom.md).

Further, you can call any public or protected _Template_ method from the
template file. (This is because the template file is executed "inside" the
_Template_ object.) Among other things, you can set the layout, or render
other templates, from inside any template:

```qiq
{{ setLayout ('seasonal-layout') }}

{{= render ('some/other/template') }}
```
