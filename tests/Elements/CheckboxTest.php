<?php

namespace HtmlForm\Elements;

class CheckboxTest extends \PHPUnit\Framework\TestCase
{
	public function testCompileWithValue()
	{
    $field = new Checkbox("test", "Test", array("test", "blue"), array(
      "help" => "help text"
    ));

    $expected = "<div class=\"label\">Test</div><div class='help'>help text</div><div class=\"elements\"><div class=\"element\"><label><input type=\"checkbox\"  name=\"test[]\" value=\"test\" checked=\"checked\" /> <span>test</span></label></div><div class=\"element\"><label><input type=\"checkbox\"  name=\"test[]\" value=\"blue\"  /> <span>blue</span></label></div></div>";
		$value = $field->compile("test");

    $this->assertEquals($expected, $value);
	}

	public function testCompileWithNumericValue()
	{
    $field = new Checkbox("test", "Test", array("test", "blue"), array("useNumericValue" => true));

		$expected = "<div class=\"label\">Test</div><div class=\"elements\"><div class=\"element\"><label><input type=\"checkbox\"  name=\"test[]\" value=\"0\" checked=\"checked\" /> <span>test</span></label></div><div class=\"element\"><label><input type=\"checkbox\"  name=\"test[]\" value=\"1\"  /> <span>blue</span></label></div></div>";
		$value = $field->compile(0);

		$this->assertEquals($expected, $value);
	}
}
