# Static Analysis

Qiq template files are easily analyzed by static analysis tools such as
PHPStan. Only a docblock is required to enable analysis. This docblock is
what makes the _Template_ methods, helpers, and variables recognizable by the
analyzer.

## Enabling Analysis

In each template file to be analyzed, add a docblock to specify a type for
`$this`, using an intersection type of _Qiq\Engine_ and your _Helpers_ object.

You should also be sure to document each variable used in the template file.

In PHP code, the docblock might look like this ...

```html+php
<?php
/**
 * @var \Qiq\Engine&\Qiq\Helper\Html\HtmlHelpers $this
 * @var string $name
 */
?>

Hello <?= $this->h($name) ?>!
```

... whereas the Qiq syntax might look like this:

```qiq
{{ /** @var \Qiq\Engine&\Qiq\Helper\Html\HtmlHelpers $this */ }}
{{ /** @var string $name */ }}

Hello {{h $name }}!
```

### Custom Typing

If you find that typehint too verbose, your static analyzer may let you define
a custom pseudo-type. For example, a PHPStan configuration entry might define
this type alias:

```yaml
parameters:
    typeAliases:
        HtmlTemplate: \Qiq\Engine&\Qiq\Helper\Html\HtmlHelpers
```

Then in your template file docblock, you can specify `$this` as the custom type:

```qiq
{{ /** @var HtmlTemplate $this */ }}
```

### Mixins

Alternatively, you may wish to extend the _Template_ class itself and specify
a `@mixin` for the appropriate _Helpers_ class. For example:

```php
namespace Project;

use Qiq\Catalog;
use Qiq\Helper\Html\HtmlHelpers;
use Qiq\Template;

/**
 * @mixin HtmlHelpers
 */
class HtmlTemplate extends Template
{
    public function __construct(
        Catalog $catalog,
        HtmlHelpers $helpers
    ) {
        parent::__construct($catalog, $helpers)
    }
}
```

Then in your template file docblock, you can use the extended class name:

```qiq
{{ /** @var Project\HtmlTemplate $this */ }}
```

## Performing Analysis

If your template files are PHP only, that's enough: you can run static
analysis against them as they are in their source locations.

However, for template files with Qiq syntax, you will need to compile the
template files to PHP as a precursor to static analysis. To do so,
instantiate the _Template_ class that will render the template files, and
`compileAll()` of the template files in the _Catalog_:


```php
$cachePath = '/path/to/compiled';

$template = Template::new(
    paths: ...,
    cachePath: $cachePath,
);

$template->getCatalog()->compileAll();
```

You can then run static analysis against the `$cachePath` directory of
compiled template files (**not** the source template files, since they have
non-analyzable Qiq code in them).

Given the above `$cachePath` example, a PHPStan configuration entry for static
analysis of the compiled template files might include an entry like this:

```neon
parameters:
    paths:
        - /path/to/compiled/
```

## Resolving Analysis Issues

Debugging and resolving issues revealed by static analysis is straightforward.

Because the compiled template files are saved in the `$cachePath` using the
source template file path, it is easy to see which source template file
contains the issue.

Further, because the compiled template code lines match the source template
code lines, the reported line numbers match up as well.

From there, resolve the issue in the source template file as you would in any
other PHP code, recompile, and re-analyze.
