# Upgrading

## 1.x to 2.x

Upgrading from Qiq 1.x to 2.x is straightforward but may be time consuming.

### Assigned Variables

Magic `__get()`, `__set()`, etc. access to assigned variables has been removed.

This means template files **no longer use `$this->var`** for assigned variables.

Instead, they now use `$var` (without the `$this->` prefix). This is in support
of [static analysis](./static-analysis.md) in template files.

If you need to modify the assigned variables directly, use `&refData()` to get
a reference to the array of assigned data. Modifications to this array will
be honored on the next call to `render()`.

### Sections and Blocks

Sections have been removed entirely in favor of blocks. Instead of
`setSection()`, `preSection()`, `addSection()`, and `getSection()`, use
`setBlock()`, `parentBlock()`, and `getBlock()`. Please see the
[blocks](./blocks.md) documentation for more information.

### Helpers

The _HelperLocator_ has been removed entirely in favor of _Helpers_ and
a _Container_. If you have custom helpers, you will need to following the
[custom helpers](./helpers/custom.md) documentation to make them available in
your templates.

The tag-related helpers no longer use arrays for attributes; instead, they use
named parameters. For example, an input text field helper in 1.x would have
been called like this:

```qiq
{{= textField ([
  'name' => 'foo',
  'value' => 'foo text',
  'id' => 'foo-id',
]) }}
```

In 2.x, you call it like this; note that the array and its keys are replaced
by named parameters:

```qiq
{{= textField (
  name: 'foo',
  value: 'foo text',
  id: 'foo-id',
) }}
```

As a transitional aid, you may use the spread (`...`) operator to expand the
array into named parameters:

```qiq
{{= textField (...[
  'name' => 'foo',
  'value' => 'foo text',
  'id' => 'foo-id',
]) }}
```

Further:

- All PHP functions must be prefixed with `\` to distinguish them from
  Helper methods. Whereas previously you could use `{{h strtoupper($var) }}`
  you must now use `{{h \strtoupper($var) }}`. This is in support of
  improved static analysis.

- All HTML helpers have been moved from the _Qiq\Helper_ namespace to the
  _Qiq\Helper\Html_ namespace; the _Helper_ class has been renamed
  to _TagHelper_.

- The _Escape_ class is now defined in the the _Qiq\Helper\Html_ namespace, not
  the _Qiq_ namespace.

- The attribute builder no longer honors the `_raw` pseudo-attribute. If you
  want tag body text to be unescaped, you will need to build it manually.

- The `_default` pseudo-attribute in various form-related helpers has been
  replaced with the named parameter `default`.

- The `_options` pseudo-attribute in various form-related helpers has been
  replaced with the named parameter `options`.


### Static Analysis

All Qiq code now declares `strict_types=1` and is covered by static analysis.
Normally this would mean your calling code might have to be more strict about
what it sends to Qiq.

However, most string-like parameters are typed as `mixed`, with `@param`
docblocks indicating the type as `null|scalar|Stringable` (or arrays thereof).
This is because casting a `mixed` value to `string` is flagged by static
analysis tools when being escaped for string output.

As a result, you should not have to recast the values you send to Qiq much, if
at all -- but be aware of these changes nonetheless.

### Other Changes

- An _Engine_ interface has been introduced.

- _TemplateCore_ has been renamed to _Kernel_, and implements the _Engine_
  interface.

- `Template::new()` has been moved to `Kernel::new()`.

- _TemplateLocator_ has been renamed to _Catalog_; `TemplateLocator::get()` is
   now `Catalog::getCompiled()`.

- The _Compiler_ interface is now defined in the _Qiq_ namespace, not
  the _Qiq\Compiler_ namespace.

- The _Exception_ class is now defined in the _Qiq_ namespace, not
  the _Qiq\Exception_ namespace.

- The _HelperNotFound_ exception has been renamed to _ObjectNotFound_, and
  implements the PSR-11 _NotFoundExceptionInterface_.

- The _TemplateNotFound_ exception has been renamed to _FileNotFound_.

- The _Indent_ class now uses instance methods, not static methods, and is
  shared as an instance in the _Container_.
