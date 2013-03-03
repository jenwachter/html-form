<?php

namespace HtmlForm\tests;

class TextareaTest extends \HtmlForm\tests\Test
{
	protected $testClass;
	protected $reflection;

	public function setUp()
	{
		$this->testClass = new \HtmlForm\Elements\Textarea("testField", "Test Field");
		$this->reflection = new \ReflectionClass("\\HtmlForm\\Elements\\Textarea");
	}

	public function testCompile()
	{
		$expected = "<label for=\"testField\">Test Field</label><textarea name=\"testField\" ></textarea>";
		$this->assertEquals($expected, $this->testClass->compile());
	}

	public function testCompileWithAttributes()
	{
		$this->setProperty("attr", array("something" => "cool"));
		$this->testClass->compileAttributes();

		$expected = "<label for=\"testField\">Test Field</label><textarea name=\"testField\" something=\"cool\"></textarea>";
		$this->assertEquals($expected, $this->testClass->compile());
	}

	public function testCompileWithValue()
	{
		$expected = "<label for=\"testField\">Test Field</label><textarea name=\"testField\" >test</textarea>";
		$this->assertEquals($expected, $this->testClass->compile("test"));
	}
}