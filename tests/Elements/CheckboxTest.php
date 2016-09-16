<?php

namespace HtmlForm\Elements;

class CheckboxTest extends \PHPUnit_Framework_TestCase
{
	public function testCompileWithValue()
	{
    $field = new Checkbox("test", "Test", array("test", "blue"), array(
      "help" => "help text"
    ));

    $expected = "<label for=\"test\">Test</label><div class=\"elements\"><div class=\"element\"><input type=\"checkbox\"  name=\"test[]\" value=\"test\" checked=\"checked\" /> <span>test</span></div><div class=\"element\"><input type=\"checkbox\"  name=\"test[]\" value=\"blue\"  /> <span>blue</span></div></div><div class='help'>help text</div>";
		$value = $field->compile("test");

    $this->assertEquals($expected, $value);
	}

	public function testCompileWithNumericValue()
	{
    $field = new Checkbox("test", "Test", array("test", "blue"), array("useNumericValue" => true));

		$expected = "<label for=\"test\">Test</label><div class=\"elements\"><div class=\"element\"><input type=\"checkbox\"  name=\"test[]\" value=\"0\" checked=\"checked\" /> <span>test</span></div><div class=\"element\"><input type=\"checkbox\"  name=\"test[]\" value=\"1\"  /> <span>blue</span></div></div>";
		$value = $field->compile(0);

		$this->assertEquals($expected, $value);
	}
}
