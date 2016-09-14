<?php

namespace HtmlForm\Elements;

class TextareaTest extends \HtmlForm\Base
{
	protected $testClass;
	protected $reflection;

	public function setUp()
	{
		$this->testClass = new \HtmlForm\Elements\Textarea("testField", "Test Field");
		parent::setUp();
	}

	public function testCompile()
	{
		$expected = "<label for=\"testField\">Test Field</label><textarea name=\"testField\" ></textarea>";
		$this->assertEquals($expected, $this->testClass->compile());
	}

	public function testCompileWithAttributes()
	{
		$this->setProperty("compiledAttr", "something=\"cool\"");

		$expected = "<label for=\"testField\">Test Field</label><textarea name=\"testField\" something=\"cool\"></textarea>";
		$this->assertEquals($expected, $this->testClass->compile());
	}

	public function testCompileWithValue()
	{
		$expected = "<label for=\"testField\">Test Field</label><textarea name=\"testField\" >test</textarea>";
		$this->assertEquals($expected, $this->testClass->compile("test"));
	}
}