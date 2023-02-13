<?php foreach (['bar', 'baz', 'dib'] as $foo) {
    /** @var Qiq\Engine&Qiq\Helper\Html\HtmlHelpers $this */
    echo $this->render('_partial', [
        'foo' => $foo,
    ]);
}
