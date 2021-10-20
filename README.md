# Qiq Templates for PHP 8

This package provides a PHP 8.0 implementation of the
[TemplateView](http://martinfowler.com/eaaCatalog/templateView.html) and
[TwoStepView](http://martinfowler.com/eaaCatalog/twoStepView.html) patterns
using PHP itself as the templating language, along with an optional `{{ ... }}`
syntax for concise escaping and helper use.

## Background

I don't like compiled templates or specialized template languages. Smarty, Twig,
etc. are all just too heavy-handed. I don't need a new language, and I don't
need to "secure" my templates against designers on my team. I am generally
happy with plain PHP as a template language.

However, I do find escaping tedious -- necessary, and easy enough, but tedious.
A template helper to output escaped HTML, like this ...

```
<?= $this->h($var) ?>
```

... is not that bad -- but even so, it could be a *little* easier. Imagine this
little bit of syntax sugar:

```
{{h $var }}
```

All that happens is that `{{h ... }}` is replaced with `<?= $this->h(...) ?>`.

Once that is in place, it becomes easy to support helpers, control structures,
and other code, all while keeping native PHP as the fallback syntax, because
the `{{ ... }}` tags are essentially stand-ins for PHP tags.

Qiq really is PHP -- just with some syntax sugar when you want it.

## History

Qiq's relatives include ...

- The Savant family:
    - [Savant 1 and 2](https://github.com/pmjones/savant)
    - [Savant 3](https://github.com/saltybeagle/Savant3)
    - [PEAR Templates_Savant](https://github.com/pear2/Templates_Savant/)
    - [Savvy](https://github.com/saltybeagle/Savvy)
- [Solar_View](http://solarphp.com/manual/views)
- [Aura.View](http://auraphp.com/packages/2.x/View.html)
- [Laminas View](https://docs.laminas.dev/laminas-view/) (nee Zend_View)

This package is more closely related to Aura.View than to the pre-Composer
versions of Savant, but does reintroduce the Savant compiler hook ideas.
