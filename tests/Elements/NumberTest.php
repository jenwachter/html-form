<?php

namespace HtmlForm\Elements;

class NumberTest extends \PHPUnit\Framework\TestCase
{
	public function testCompile()
	{
    $field = new Number("test", "Test", ['required' => true]);

    $expected = "<label for=\"test_id\"><span class=\"required\">*</span> Test</label><input id=\"test_id\" type=\"number\" name=\"test\" required  value=\"\" />";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

	public function testValidateType()
  {
    $field = new Number("test", "Test");

		$result = $field->validateType("a string");
		$this->assertFalse($result);

		$result = $field->validateType("11");
		$this->assertTrue($result);

		$result = $field->validateType(20);
		$this->assertTrue($result);

		$result = $field->validateType(20.5);
		$this->assertTrue($result);
  }
}
