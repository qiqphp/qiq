<?php
declare(strict_types=1);

namespace Qiq;

use stdClass;

interface Engine
{
    public function setIndent(string $base) : void;

    public function setData(array|stdClass $data) : void;

    public function addData(iterable $data) : void;

    public function getData() : array;

    public function &refData() : array;

    public function setLayout(?string $layout) : void;

    public function getLayout() : ?string;

    public function setView(?string $view) : void;

    public function getView() : ?string;

    public function getContent() : string;

    public function extends(string $extends) : void;

    public function setBlock(string $name) : void;

    public function parentBlock() : void;

    public function endBlock() : void;

    public function getBlock() : string;

    public function render(string $__NAME__, array $__LOCAL__ = []) : string;
}
