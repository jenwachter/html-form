<?php

namespace HtmlForm\Elements;

class TextareaTest extends \PHPUnit_Framework_TestCase
{
	public function testCompile()
	{
    $field = new Textarea("test", "Test", array("help" => "help text"));

    $expected = "<label for=\"test\">Test</label><textarea name=\"test\" ></textarea><div class='help'>help text</div>";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
