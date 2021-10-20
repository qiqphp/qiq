<?php
echo ($this->hasSection('main') ? 'true' : 'false') . PHP_EOL;

$this->setSection('main');
echo 'foo';
$this->endSection();

echo ($this->hasSection('main') ? 'true' : 'false') . PHP_EOL;

$this->appendSection('main');
echo 'bar';
$this->endSection();

$this->prependSection('main');
echo 'baz';
$this->endSection();

echo $this->getSection('main');
