<?php

namespace HtmlForm\Elements;

class RangeTest extends \PHPUnit\Framework\TestCase
{
	public function testCompile()
	{
    $field = new Range("test", "Test", 5, 10);

    $expected = "<label for=\"test_id\">Test</label><input id=\"test_id\" type=\"number\" name=\"test\" min=\"5\" max=\"10\" value=\"\" />";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

	public function testValidateType()
  {
    $field = new Range("range", "range", 10, 20);

		$result = $field->validateType("range", "NaN", $element);
    $this->assertFalse($result);

    $result = $field->validateType("range", 5, $element);
    $this->assertFalse($result);

    $result = $field->validateType("range", 15, $element);
    $this->assertTrue($result);

	}
}
