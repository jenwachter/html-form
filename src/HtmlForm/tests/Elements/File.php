<?php

namespace HtmlForm\tests\Elements;

class FileTest extends \HtmlForm\tests\Base
{
	protected $testClass;
	protected $reflection;

	public function setUp()
	{
		$this->testClass = new \HtmlForm\Elements\File("testField", "Test Field");
		$this->reflection = new \ReflectionClass("\\HtmlForm\\Elements\\File");
	}

	public function testType()
	{
		$this->assertEquals("file", $this->testClass->type);
	}

	public function testCompile()
	{
		$expected = "<label for=\"testField\">Test Field</label><input type=\"file\" name=\"testField\"  value=\"\" />";
		$this->assertEquals($expected, $this->testClass->compile());
	}
}