<?php

namespace HtmlForm\tests\Elements\Parents;

class TextboxTest extends \HtmlForm\tests\Test
{
	protected $testClass;
	protected $reflection;

	public function setUp()
	{
		$args = array(
			"testField",
			"Test Field"
		);

		$this->testClass = $this->getMockForAbstractClass("\\HtmlForm\\Elements\\Parents\\Textbox", $args);
		$this->reflection = new \ReflectionClass("\\HtmlForm\\Elements\\Parents\\Textbox");
	}

	public function testType()
	{
		$this->assertEquals("text", $this->testClass->type);
	}

	public function testCompile()
	{
		$expected = "<label for=\"testField\">Test Field</label><input type=\"text\" name=\"testField\"  value=\"\" />";
		$this->assertEquals($expected, $this->testClass->compile());
	}

	public function testCompileWithRequired()
	{
		$this->setProperty("required", true);
		$this->testClass->compileLabel();
		$expected = "<label for=\"testField\">* Test Field</label><input type=\"text\" name=\"testField\"  value=\"\" />";
		$this->assertEquals($expected, $this->testClass->compile());
	}

	public function testCompileWithAttr()
	{
		$this->setProperty("attr", array("something" => "cool"));
		$this->testClass->compileAttributes();
		
		$expected = "<label for=\"testField\">Test Field</label><input type=\"text\" name=\"testField\" something=\"cool\" value=\"\" />";
		$this->assertEquals($expected, $this->testClass->compile());
	}

	public function testCompuileWithValue()
	{
		$expected = "<label for=\"testField\">Test Field</label><input type=\"text\" name=\"testField\"  value=\"test\" />";
		$this->assertEquals($expected, $this->testClass->compile("test"));
	}
}