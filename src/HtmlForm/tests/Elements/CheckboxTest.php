<?php

namespace HtmlForm\tests;

class CheckboxTest extends \HtmlForm\tests\Test
{
	protected $testClass;
	protected $reflection;

	public function setUp()
	{
		$this->testClass = new \HtmlForm\Elements\Checkbox("testField", "Test Field", array("test", "blue"));
		$this->reflection = new \ReflectionClass("\\HtmlForm\\Elements\\Checkbox");
	}

	public function testType()
	{
		$this->assertEquals("checkbox", $this->testClass->type);
	}

	public function testCompileWithNoOptionValue()
	{
		$expected = "<label for=\"testField\">Test Field</label><input type=\"checkbox\"  name=\"testField[]\" value=\"test\"  /> test<input type=\"checkbox\"  name=\"testField[]\" value=\"blue\"  /> blue";
		$value = $this->testClass->compile();
		$this->assertEquals($expected, $value);
	}

	public function testCompileWithValue()
	{
		$expected = "<label for=\"testField\">Test Field</label><input type=\"checkbox\"  name=\"testField[]\" value=\"test\" checked=\"checked\" /> test<input type=\"checkbox\"  name=\"testField[]\" value=\"blue\"  /> blue";
		$value = $this->testClass->compile("test");
		$this->assertEquals($expected, $value);
	}

	public function testCompileWithOptionValue()
	{
		$this->setProperty("options", array("one" => "test", "two" => "blue"));
		$expected = "<label for=\"testField\">Test Field</label><input type=\"checkbox\"  name=\"testField[]\" value=\"one\"  /> test<input type=\"checkbox\"  name=\"testField[]\" value=\"two\"  /> blue";
		$value = $this->testClass->compile();
		$this->assertEquals($expected, $value);
	}

	public function testCompileWithOptionValueWithValue()
	{
		$this->setProperty("options", array("one" => "test", "two" => "blue"));
		$expected = "<label for=\"testField\">Test Field</label><input type=\"checkbox\"  name=\"testField[]\" value=\"one\" checked=\"checked\" /> test<input type=\"checkbox\"  name=\"testField[]\" value=\"two\"  /> blue";
		$value = $this->testClass->compile("one");
		$this->assertEquals($expected, $value);
	}

	public function testCompileWithAttr()
	{
		$this->setProperty("attr", array("something" => "cool"));
		$this->testClass->compileAttributes();

		$expected = "<label for=\"testField\">Test Field</label><input type=\"checkbox\" something=\"cool\" name=\"testField[]\" value=\"test\"  /> test<input type=\"checkbox\" something=\"cool\" name=\"testField[]\" value=\"blue\"  /> blue";
		$value = $this->testClass->compile();
		$this->assertEquals($expected, $value);
	}
}