# Template Locator

Qiq will search through any number of directory paths for named templates. You
can pass an array of `paths` to `Template::new()` ...

```php
$tpl = Template::new(
    paths: [
        '/path/to/custom/templates',
        '/path/to/default/templates',
    ],
);
```
... or you can tell the _TemplateLocator_ directly:

```php
$tpl->getTempLatelocator()->setPaths([
    '/path/to/custom/templates',
    '/path/to/default/templates',
]);
```

The _TemplateLocator_ will search for the named template from the first
directory path to the last.

```php
/*
searches first for:  /path/to/custom/templates/foo.php,
and then second for: /path/to/default/templates/foo.php
*/
$output = $tpl('foo');
```

If you like, you can modify the paths after the _Template_ instantiation to
append or prepend a directory path to the _TemplateLocator_:

```php
$tpl->getTemplateLocator()->prependPath('/higher/precedence/templates');
$tpl->getTemplateLocator()->appendPath('/lower/precedence/templates');
```

### Subdirectories

To render a template from any location, use the absolute path to the template
name:

```php
// renders the "foo/bar/baz.php" template
$output = $tpl('foo/bar/baz');
```

Alternatively, while inside a template, you may refer to template names by
relative path. Use `./` to indicate a template in the same directory, or
`../` to indicate the directory above the current one.

Given a template file structure like the following ...

```
foo.php
foo/
    bar.php
    bar/
        baz.php
        dib.php
```

... while inside the `foo/bar/baz.php` template file:

```php
// refers to "foo/bar/dib.php"
echo $this->render('./dib');

// refers to "foo/bar.php"
echo $this->render('../bar');

// refers to "foo.php"
echo $this->render('../../foo');
```

### File Name Extension

By default, the _TemplateLocator_ will auto-append `.php` to template file
names. If the template files end with a different extension, change it using the
`setExtension()` method:

```php
$templateLocator = $tpl->getTempLatelocator();
$templateLocator->setExtension('.phtml');
```

Or, you can set it at _Template_ creation time:

```php
$tpl = Template::new(
    extension: '.phtml'
);
```

### Collections

Sometimes it may be useful to identify collections of templates, say for
emails or for admin pages. (Other systems may refer to these as "groups",
"folders", or "namespaces".)

To associate a directory path with a collection, prefix the path with the
collection name and a colon:

```php
$tpl = new Template(
    paths: [
        'admin:/path/to/admin/templates',
        'email:/path/to/email/templates',
    ]
);
```

To render a template from a collection, prefix the template name with the
collection name.

```php
$output = $tpl('email:notify/subscribed');
```

You can set, append, and prepend collection paths, the same as you would with
the "main" or "default" collection of unprefixed template paths.
