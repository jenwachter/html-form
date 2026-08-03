<?php

namespace HtmlForm\Elements;

class EmailTest extends \PHPUnit\Framework\TestCase
{
	public function testCompile()
	{
    $field = new Email("test", "Test");

    $expected = "<label for=\"test_id\">Test</label><input id=\"test_id\" type=\"email\" name=\"test\"  value=\"\" />";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

	public function testValidateType()
  {
    $field = new Email("test", "Test");

		$result = $field->validateType("test@test.com");
		$this->assertTrue($result);

		$result = $field->validateType("test@test");
		$this->assertFalse($result);
  }
}
