# Sections

Sections are similar to partials, except that they are captured inline for later
use. In general, they are used by view templates to capture output for layout
templates.

For example, you can capture output in the view template to a named section ...

```html+php
{{ setSection ('local-nav') }}
    <!-- ... local navigation items ... -->
{{ endSection () }}
```

... and then use that output in a layout template:

```html+php
<div id="local-nav">
    {{= getSection ('local-nav') }}
</div>
```

Using `setSection()` will overwrite any previous content for that section. Use
`preSection()` to prepend, and `addSection()` to append, to a section.

```html+php
{{ preSection ('local-nav')}}
<!-- add items to the top of the nav -->
{{ endSection() }}

{{ addSection ('local-nav')}}
<!-- add items to the end of the nav -->
{{ endSection() }}
```

You can see if a section exists using `hasSection()`:

```html+php
{{ if ($this->hasSection('local-nav')): }}
<div id="local-nav">
    {{= getSection ('local-nav') }}
</div>
{{ endif }}
```
