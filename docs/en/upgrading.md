TemplateLocator is now Catalog.

HelperLocator is now Container.

If you have custom helpers, you must extend Template (or HtmlTemplate) and add the helpers as methods on your extended Template. You ca get helper objects using Template::getObject().

All of your template variables must chagne from $this->foo to just $foo.
