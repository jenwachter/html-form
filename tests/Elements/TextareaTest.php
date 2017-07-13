<?php

namespace HtmlForm\Elements;

class TextareaTest extends \PHPUnit_Framework_TestCase
{
	public function testCompile()
	{
    $field = new Textarea("test", "Test", array("help" => "help text"));

    $expected = "<label for=\"test\">Test</label><div class='help'>help text</div><textarea name=\"test\" ></textarea>";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
