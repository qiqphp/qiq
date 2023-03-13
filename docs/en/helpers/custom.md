# Custom Helpers

You can provide your _Template_ objects with a custom _Helpers_ object. In
that custom _Helpers_ object, you can add any helper methods you like. Your
helper methods will available inside template files processed by
that _Template_ instance.

## Creating A _Helpers_ Class

The easiest thing to do is extend _HtmlHelpers_ and add a method on that new
class.

For example, the following custom _Helpers_ class adds a method to ROT-13 a
string, escaping it appropriately:

```php
<?php
namespace Project\Template\Helper;

use Qiq\Helper\Html\HtmlHelpers;

class CustomHelpers extends HtmlHelpers
{
    public function rot13(string $str) : string
    {
        return $this->h(str_rot13($str));
    }
}
```

Alternatively, you can extend the base _Helpers_ object, and use
the _HtmlHelperMethods_ trait:

```php
<?php
namespace Project\Template\Helper;

use Qiq\Helper\Html\HtmlHelperMethods;
use Qiq\Helpers;

class CustomHelpers extends Helpers
{
    use HtmlHelperMethods;

    public function rot13(string $str) : string
    {
        return $this->h(str_rot13($str));
    }
}
```

Finally, if you are not using HTML at all, you can just extend the _Helpers_
class.

```php
<?php
namespace Project\Template\Helper;

use Qiq\Helpers;

class CustomHelpers extends Helpers
{
    public function rot13(string $str) : string
    {
        return str_rot13($str);
    }
}
```



## Using Your _Helpers_

Once you have a custom _Helpers_ class, create your _Template_ with an
instance of it:

```php
use Project\Template\Helper\CustomHelpers;
use Qiq\Template;

$template = Template::new(
    paths: ...,
    helpers: new CustomHelpers(),
);
```

Now you can use your custom helper methods in a template file, either in plain
PHP ...

```html+php
<?= $this->rot13('Uryyb Jbeyq!'); ?>
```

... or in Qiq syntax:

```html+php
{{= rot13 ('Uryyb Jbeyq!') }}
```

Either way, the output will be "Hello World!".

## Helper Classes

If you like, you can put your helper logic in a class, then retrieve an
instance of that class from the autowiring _Qiq\Container_ (described below)
using `$this->get()`.

For example, if you put the ROT-13 logic into a class ...

```php
<?php
namespace Project\Template\Helper;

use Qiq\Helper\Html\Escape;

class Rot13
{
    public function __construct(protected Escape $escape)
    {
    }

    public function __invoke(string $str): string
    {
        return $this->escape->h(str_rot13($str));
    }
}
```

... you can then `get()` an instance of that class from inside your
custom _Helpers_ object and use it as you wish:


```php
<?php
namespace Project\Template\Helper;

use Project\Template\Helper\Rot13;
use Qiq\Helper\Html\HtmlHelpers;

class CustomHelpers extends HelperHelpers
{
    public function rot13(string $str) : string
    {
        return $this->get(Rot13::class)->__invoke($str);
    }
}
```

## _Helpers_ Container

The _Helpers_ class uses an autowiring _Qiq\Container_ object. In your custom
helper methods, you can use `$this->get()` to retrieve an object from
the _Qiq\Container_.

To configure the _Qiq\Container_, instantiate it with an array of class
constructor parameter names and values, and create your _Helpers_ with it.
For example, to change the _Escape_ encoding to something other than UTF-8:

```php
use Project\Template\Helper\CustomHelpers;
use Qiq\Container;
use Qiq\Helper\Html\Escape;
use Qiq\Template;

$container = new Container([
    Escape::class => [
        'encoding' => 'EUC-JP'
    ],
]);

$template = Template::new(
    paths: ...,
    helpers: new CustomHelpers($container))
);
```

The _Qiq\Container_ is relatively low-powered. If you wish, you can replace
the _Qiq\Container_ with any [PSR-11](https://www.php-fig.org/psr/psr-11/)
_ContainerInterface_ instance:

```php
use Project\Template\Helper\CustomHelpers;
use Project\Psr11Container;
use Qiq\Template;

$psr11container = new Psr11Container();

$template = Template::new(
    paths: ...,
    helpers: new CustomHelpers($psr11container)
);
```
