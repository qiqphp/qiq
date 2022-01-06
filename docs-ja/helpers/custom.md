# カスタムヘルパー

カスタムヘルパーを開発するのは簡単です。ヘルパークラスを作成し、HelperLocatorに登録し、テンプレートで使用します。

## ヘルパークラス

ヘルパーを書くには、Helperクラスを継承し、`__invoke()`メソッドを好きなパラメータで実装してください。このメソッドは、適切にエスケープされた文字列を返すようにします。

以下は、文字列をROT-13するためのヘルパーです。

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

## ヘルパーのロケーター

ヘルパークラスができたので、その呼び出し可能なファクトリをHelperLocatorに登録する必要があります。(呼び出し可能なファクトリを登録すると、ヘルパーが呼ばれたときにだけHelperLocatorがヘルパーを遅延ロードするようになります)。登録キーはQiqヘルパー名、あるいはテンプレート内でそのヘルパーに使用する、PHPの`$this`ヘルパーメソッドとなります

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

HelperLocatorにすでにEscapeのインスタンスがある状態でHelperクラスを構築する必要があることに注意してください。

## ヘルパーを使用する

このヘルパーは、Qiqコードとしてテンプレートで使用することができます。

```
<p>{{= rotOneThree ('Uryyb Jbeyq!') }}</p>
```

あるいはPHPで

```html+php
<p><?= $this->rotOneThree('Uryyb Jbeyq!') ?></p>
```

いずれにせよ、出力は同じになります。

```html
<p>Hello World!</p>
```
