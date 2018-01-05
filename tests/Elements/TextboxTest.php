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

	public function testRequiredValidation()
	{
		$field = new Textbox("test", "Test", array("required" => true));
		$expected = array('"Test" is a required field.');
		$field->validate();
    $this->assertEquals($expected, $field->errors);

		$field = new Textbox("testField", "Test", array("required" => true));
		$expected = array();
		$field->validate();
    $this->assertEquals($expected, $field->errors);
	}

	public function testPattern()
  {
    $field = new Textbox("test", "Test", array("attr" => array("pattern" => "\d{4}")));

    $result = $field->validatePattern(2016);
    $this->assertTrue($result);

    $result = $field->validatePattern("string");
    $this->assertFalse($result);

    $result = $field->validatePattern(123);
    $this->assertFalse($result);
  }
}
