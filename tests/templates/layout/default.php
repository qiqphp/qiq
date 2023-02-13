<?php /** @var Qiq\Engine&Qiq\Helper\Html\HtmlHelpers $this */ ?>
<?php /** @var stringy $title */ ?>
<?= $title
   . " -- before -- "
   . $this->getContent()
   . " -- after";
