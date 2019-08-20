<?php

namespace HtmlForm\Elements;

class TextareaTest extends \PHPUnit\Framework\TestCase
{
	public function testCompile()
	{
    $field = new Textarea("test", "Test", array("help" => "help text"));

    $expected = "<label for=\"test_id\">Test</label><div class='help'>help text</div><textarea id=\"test_id\" name=\"test\" ></textarea>";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
