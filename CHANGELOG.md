# Change Log

## 1.1.1

- Recognize `::` in opening keywords. Previously, something like `{{ Foo::bar() }}` would have been compiled incorrectly as `<?php $this->Foo::bar() ?>`, but now correctly compiles to `<?php Foo::bar() ?>`.

## 1.1.0

- Add `{{= ... ~}}` syntax to consume trailing newline (#17)
- Add Jinja/Twig-like inheritance and blocks
- Add TemplateCore::hasTemplate() as shortcut to TemplateLocator::has()
- Add documentation in Japanese (#5)
- Add new factories (#9)
- Template::new() now takes a HelperLocator and Compiler directly, and returns static instead of self to allow better extension
- Add improved indent logic in compiler, to help keep the source code lines and compiled code lines the same.
- Add relative template path support (#14)

## 1.0.2

- Improved support for Windows

- Infrastructure improvements (thanks @harikt)

## 1.0.1

- Recognize more opening keywords: `isset`, `empty`, `list`.

- Update docs.

## 1.0.0

Initial release.
