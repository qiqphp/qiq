<?php /** @var Qiq\Engine&Qiq\Helper\Html\HtmlHelpers $this */ ?>
<?php /** @var string $title */ ?>
<?= $title
   . " -- before -- "
   . $this->getContent()
   . " -- after";
