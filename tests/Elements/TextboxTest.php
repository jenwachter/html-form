<?php

namespace HtmlForm\Elements;

class TextboxTest extends \PHPUnit\Framework\TestCase
{
	public function testCompile()
	{
    $field = new Textbox("test", "Test");

    $expected = "<label for=\"test_id\">Test</label><input id=\"test_id\" type=\"text\" name=\"test\"  value=\"\" />";
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

  public function testMaxlength()
  {
    $field = new Textbox("test", "Test", array("attr" => array("maxlength" => 10)));

    $result = $field->validateMaxlength("12345678901234");
    $this->assertFalse($result);

    $result = $field->validateMaxlength("1234567890");
    $this->assertTrue($result);

    $result = $field->validateMaxlength("1234");
    $this->assertTrue($result);
  }
}
