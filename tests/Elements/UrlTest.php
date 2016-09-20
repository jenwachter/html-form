<?php

namespace HtmlForm\Elements;

class UrlTest extends \PHPUnit_Framework_TestCase
{
	public function testCompile()
	{
    $field = new Url("test", "Test");

    $expected = "<label for=\"test\">Test</label><input type=\"url\" name=\"test\"  value=\"\" />";
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
