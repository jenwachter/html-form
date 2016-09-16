<?php

namespace HtmlForm\Elements;

class SelectTest extends \PHPUnit_Framework_TestCase
{
	public function testCompile()
	{
    $field = new Select("test", "Test", array("test", "blue"), array("help" => "help text"));

    $expected = "<label for=\"test\">Test</label><select name=\"test\" ><option value=\"test\" selected=\"selected\">test</option><option value=\"blue\">blue</option></select><div class='help'>help text</div>";
		$value = $field->compile("test");

    $this->assertEquals($expected, $value);
	}

	public function testCompileWithNumericValue()
	{
    $field = new Select("test", "Test", array("test", "blue"), array("useNumericValue" => true));

		$expected = "<label for=\"test\">Test</label><select name=\"test\" ><option value=\"0\" selected=\"selected\">test</option><option value=\"1\">blue</option></select>";
		$value = $field->compile(0);

		$this->assertEquals($expected, $value);
	}
}
