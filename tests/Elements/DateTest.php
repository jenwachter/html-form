<?php

namespace HtmlForm\Elements;

class DateTest extends \PHPUnit\Framework\TestCase
{
	public function testCompile()
	{
    $field = new Date("test", "Test");

    $expected = "<label for=\"test_id\">Test</label><input id=\"test_id\" type=\"date\" name=\"test\"  value=\"\" />";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

	public function testValidateType()
  {
    $field = new Date("test", "Test");

		$result = $field->validateType("2015-01-01");
		$this->assertTrue($result);

		$result = $field->validateType("2015-1-01");
		$this->assertFalse($result);

		$result = $field->validateType("2015-01-1");
		$this->assertFalse($result);

		$result = $field->validateType("2015-01-40");
		$this->assertFalse($result);

		$result = $field->validateType("2015-40-1");
		$this->assertFalse($result);
  }
}
