<?php
namespace Qiq\Helper\Html;

class FormTest extends HtmlHelperTest
{
    public function test() : void
    {
        $actual = $this->helpers->form(
            action: 'http://example.com/',
            foo_bar: 'baz',
        );
        $expect = '<form method="post" action="http://example.com/" enctype="multipart/form-data" foo-bar="baz">';
        $this->assertSame($actual, $expect);
    }
}
