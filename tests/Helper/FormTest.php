<?php
namespace Qiq\Helper;

class FormTest extends HtmlHelperTest
{
    public function test() : void
    {
        $actual = $this->helpers->form([
            'method' => 'post',
            'action' => 'http://example.com/',
        ]);
        $expect = '<form method="post" action="http://example.com/" enctype="multipart/form-data">';
        $this->assertSame($actual, $expect);
    }
}
