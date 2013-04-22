<?php

namespace HtmlForm\tests\Elements;

class UrlTest extends \HtmlForm\tests\Test
{
	protected $testClass;
	protected $reflection;

	public function setUp()
	{
		$this->testClass = new \HtmlForm\Elements\Url("testField", "Test Field");
		$this->reflection = new \ReflectionClass("\\HtmlForm\\Elements\\Url");
	}

	public function testType()
	{
		$this->assertEquals("url", $this->testClass->type);
	}

	public function testCompile()
	{
		$expected = "<label for=\"testField\">Test Field</label><input type=\"url\" name=\"testField\"  value=\"\" />";
		$this->assertEquals($expected, $this->testClass->compile());
	}
}