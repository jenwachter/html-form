<?php

namespace HtmlForm\Elements;

class UrlTest extends \PHPUnit\Framework\TestCase
{
	public function testCompile()
	{
    $field = new Url("test", "Test");

		$expected = "<label for=\"test_id\">Test</label><input id=\"test_id\" type=\"url\" name=\"test\"  value=\"\" />";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

	public function testValidateType()
	{
		$field = new Url("test", "Test");

		$result = $field->validateType("https://www.google.com");
    $this->assertTrue($result);

    $result = $field->validateType("www.google.com");
    $this->assertFalse($result);
	}
}
