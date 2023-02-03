# テンプレートロケーター

Qiqは、名前付きテンプレートを任意の数のディレクトリパスから検索します。`Template::new()`に`paths`配列を渡します。

```php
$tpl = Template::new(
    paths: [
        '/path/to/custom/templates',
        '/path/to/default/templates',
    ],
);
```

あるいは、TemplateLocatorに直接指示することもできます。

```php
$tpl->getTempLatelocator()->setPaths([
    '/path/to/custom/templates',
    '/path/to/default/templates',
]);
```

TemplateLocatorは、最初のディレクトリパスから最後のディレクトリパスまで、指定されたテンプレートを検索します。

```php
/*
searches first for:  /path/to/custom/templates/foo.php,
and then second for: /path/to/default/templates/foo.php
*/
$output = $tpl('foo');
```

もし必要なら、Templateのインスタンス化の後でパスを変更し、TemplateLocatorにディレクトリパスを追加または前置することができます。

```php
$tpl->getTemplateLocator()->prependPath('/higher/precedence/templates');
$tpl->getTemplateLocator()->appendPath('/lower/precedence/templates');
```

### サブディレクトリ

任意の場所からテンプレートをレンダリングするには、テンプレート名への絶対パスを使用します。

```php
// renders the "foo/bar/baz.php" template
$output = $tpl('foo/bar/baz');
```
このほか、テテンプレート内でテンプレート名を相対パスで参照することもできます。
同じディレクトリにあるテンプレートを示すには `./` を、現在のディレクトリの上のディレクトリを示すには`../`を使用します。

以下のようなテンプレートファイル構造がある場合 ...

```
foo.php
foo/
    bar.php
    bar/
        baz.php
        dib.php
```

... `foo/bar/baz.php`テンプレートファイルから他のファイルを参照するには以下のようになります。

```php
// refers to "foo/bar/dib.php"
echo $this->render('./dib');

// refers to "foo/bar.php"
echo $this->render('../bar');

// refers to "foo.php"
echo $this->render('../../foo');
```


### ファイル名の拡張子

デフォルトでは、TemplateLocatorはテンプレートファイル名に`.php`を自動で付加します。もしテンプレートファイルの拡張子が違う場合は、`setExtension()`メソッドで変更します。

```php
$templateLocator = $tpl->getTempLatelocator();
$templateLocator->setExtension('.phtml');
```

あるいは、Template作成時に設定することもできます。

```php
$tpl = Template::new(
    extension: '.phtml'
);
```

### コレクション

メール用や管理者ページ用など、テンプレートのコレクションを識別するのが便利な場合があります。(他のシステムでは、これらを"グループ"、"フォルダ"、"名前空間"と呼ぶことがあります)。

ディレクトリパスとコレクションを関連付けるには、パスの前にコレクション名とコロンを付けます。

```php
$tpl = new Template(
    paths: [
        'admin:/path/to/admin/templates',
        'email:/path/to/email/templates',
    ]
);
```

コレクションからテンプレートをレンダリングするには、テンプレート名の前にコレクション名を付けます。

```php
$output = $tpl('email:notify/subscribed');
```

コレクションパスの設定、追加、およびプリペンドは、接頭辞なしのテンプレートパスの"main"、または"default"コレクションと同じように行うことができます。
