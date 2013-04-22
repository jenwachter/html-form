<?php

namespace HtmlForm\tests\Elements;

class RadioTest extends \HtmlForm\tests\Test
{
	protected $testClass;
	protected $reflection;

	public function setUp()
	{
		$this->testClass = new \HtmlForm\Elements\Radio("testField", "Test Field", array("test", "blue"));
		$this->reflection = new \ReflectionClass("\\HtmlForm\\Elements\\Radio");
	}

	public function testType()
	{
		$this->assertEquals("radio", $this->testClass->type);
	}

	public function testCompileWithNoOptionValue()
	{
		$expected = "<label for=\"testField\">Test Field</label><input type=\"radio\"  name=\"testField[]\" value=\"test\"  /> test<input type=\"radio\"  name=\"testField[]\" value=\"blue\"  /> blue";
		$value = $this->testClass->compile();
		$this->assertEquals($expected, $value);
	}

	public function testCompileWithOptionValue()
	{
		$this->setProperty("options", array("one" => "test", "two" => "blue"));
		$expected = "<label for=\"testField\">Test Field</label><input type=\"radio\"  name=\"testField[]\" value=\"one\"  /> test<input type=\"radio\"  name=\"testField[]\" value=\"two\"  /> blue";
		$value = $this->testClass->compile();
		$this->assertEquals($expected, $value);
	}

	public function testCompileWithValue()
	{
		$expected = "<label for=\"testField\">Test Field</label><input type=\"radio\"  name=\"testField[]\" value=\"test\" checked=\"checked\" /> test<input type=\"radio\"  name=\"testField[]\" value=\"blue\"  /> blue";
		$value = $this->testClass->compile("test");
		$this->assertEquals($expected, $value);
	}

	public function testCompileWithAttr()
	{
		$this->setProperty("compiledAttr", "something=\"cool\"");

		$expected = "<label for=\"testField\">Test Field</label><input type=\"radio\" something=\"cool\" name=\"testField[]\" value=\"test\" checked=\"checked\" /> test<input type=\"radio\" something=\"cool\" name=\"testField[]\" value=\"blue\"  /> blue";
		$value = $this->testClass->compile("test");
		$this->assertEquals($expected, $value);
	}
}