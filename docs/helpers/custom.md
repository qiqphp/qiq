# Custom Helpers

Developing a custom helper is straightforward: write a class for it, register
it with the _HelperLocator_, then use it in a template.

## The Helper Class

To write a helper, extend the _Helper_ class, and implement the `__invoke
()` method with whatever parameters you like. Have it return a string that has
been appropriately escaped.

Here is a helper to ROT-13 a string:

```php
namespace My\Helper;

use Qiq\Helper;

class Rot13 extends Helper
{
    public function __invoke(string $str) : string
    {
        return $this->escape->h(str_rot13($str));
    }
}
```

## The Helper Locator

Now that you have the helper class, you will need to register a factory for it
in the _HelperLocator_. (Registering a factory allows the _HelperLocator_ to
lazy-load the helper only when it is called.)  The registration key will be the
Qiq code word, or `$this` helper method, you use for that helper in a template.

```php
$tpl = Template::new(...);

$helperLocator = $tpl->getHelperLocator();

$helperLocator->set(
    'rotOneThree',
    function () use ($helperLocator) {
        return new \My\Helper\Rot13($helperLocator->escape());
    }
);
```

Note that you need to construct _Helper_ classes with the _Escape_ instance
already in the _HelperLocator_.

## Use The Helper

Now you can use the helper in template code.

```
Qiq:

{{= rotOneThree ('Uryyb Jbeyq!') }}

PHP:

<?= $this->rotOneThree('Uryyb Jbeyq!'); ?>
```
