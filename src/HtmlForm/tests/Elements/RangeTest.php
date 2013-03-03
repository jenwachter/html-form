<?php

namespace HtmlForm\tests;

class RangeTest extends \HtmlForm\tests\Test
{
	protected $testClass;
	protected $reflection;

	public function setUp()
	{
		$this->testClass = new \HtmlForm\Elements\Range("testField", "Test Field", 5, 10);
		$this->reflection = new \ReflectionClass("\\HtmlForm\\Elements\\Range");
	}

	public function testType()
	{
		$this->assertEquals("number", $this->testClass->type);
	}

	public function testConstructorSetProperties()
	{
		$this->assertEquals(5, $this->testClass->min);
		$this->assertEquals(10, $this->testClass->max);
	}


	public function testCompile()
	{
		$expected = "<label for=\"testField\">Test Field</label><input type=\"number\" name=\"testField\" min=\"5\" max=\"10\" value=\"\" />";
		$this->assertEquals($expected, $this->testClass->compile());
	}
}