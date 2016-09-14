<?php

namespace HtmlForm\Elements\Parents;

class TextboxTest extends \HtmlForm\Base
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
		parent::setUp();
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
		$expected = "<label for=\"testField\"><span class='required'>*</span> Test Field</label><input type=\"text\" name=\"testField\"  value=\"\" />";
		$this->assertEquals($expected, $this->testClass->compile());
	}

	public function testCompuileWithValue()
	{
		$expected = "<label for=\"testField\">Test Field</label><input type=\"text\" name=\"testField\"  value=\"test\" />";
		$this->assertEquals($expected, $this->testClass->compile("test"));
	}
}
