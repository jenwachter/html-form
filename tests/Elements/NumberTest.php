<?php

namespace HtmlForm\Elements;

class NumberTest extends \PHPUnit\Framework\TestCase
{
	public function testCompile()
	{
    $field = new Number("test", "Test");

    $expected = "<label for=\"test_id\">Test</label><input id=\"test_id\" type=\"number\" name=\"test\"  value=\"\" />";
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
