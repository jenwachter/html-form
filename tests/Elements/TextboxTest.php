<?php

namespace HtmlForm\Elements;

class TextboxTest extends \PHPUnit_Framework_TestCase
{
	public function testCompile()
	{
    $field = new Textbox("test", "Test");

    $expected = "<label for=\"test\">Test</label><input type=\"text\" name=\"test\"  value=\"\" />";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
