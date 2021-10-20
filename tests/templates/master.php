<?php foreach (['bar', 'baz', 'dib'] as $foo) {
    echo $this->render('_partial', [
        'foo' => $foo,
    ]);
}
