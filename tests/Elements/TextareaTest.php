<?php

namespace HtmlForm\Elements;

class TextareaTest extends \PHPUnit\Framework\TestCase
{
	public function testCompile()
	{
    $field = new Textarea("test", "Test", array("help" => "help text", "required" => true));

    $expected = "<label for=\"test_id\"><span class=\"required\">*</span> Test</label><div class='help'>help text</div><textarea id=\"test_id\" name=\"test\" required ></textarea>";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
