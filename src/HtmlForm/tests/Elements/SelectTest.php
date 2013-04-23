<?php

namespace HtmlForm\tests\Elements;

class SelectTest extends \HtmlForm\tests\Base
{
	protected $testClass;
	protected $reflection;

	public function setUp()
	{
		$this->testClass = new \HtmlForm\Elements\Select("testField", "Test Field", array("test", "blue"));
		$this->reflection = new \ReflectionClass("\\HtmlForm\\Elements\\Select");
	}

	public function testCompileWithNoOptionValue()
	{
		$expected = "<label for=\"testField\">Test Field</label><select name=\"testField\" ><option value=\"test\">test</option><option value=\"blue\">blue</option></select>";
		$value = $this->testClass->compile();
		$this->assertEquals($expected, $value);
	}

	public function testCompileWithOptionValue()
	{
		$this->setProperty("options", array("one" => "test", "two" => "blue"));
		$expected = "<label for=\"testField\">Test Field</label><select name=\"testField\" ><option value=\"one\">test</option><option value=\"two\">blue</option></select>";
		$value = $this->testClass->compile();
		$this->assertEquals($expected, $value);
	}

	public function testCompileWithValueAndOptionValue()
	{
		$this->setProperty("options", array("one" => "test", "two" => "blue"));
		$expected = "<label for=\"testField\">Test Field</label><select name=\"testField\" ><option value=\"one\" selected=\"selected\">test</option><option value=\"two\">blue</option></select>";
		$value = $this->testClass->compile("one");
		$this->assertEquals($expected, $value);
	}

	public function testCompileWithValue()
	{
		$expected = "<label for=\"testField\">Test Field</label><select name=\"testField\" ><option value=\"test\" selected=\"selected\">test</option><option value=\"blue\">blue</option></select>";
		$value = $this->testClass->compile("test");
		$this->assertEquals($expected, $value);
	}

	public function testCompileWithAttr()
	{
		$this->setProperty("compiledAttr", "something=\"cool\"");

		$expected = "<label for=\"testField\">Test Field</label><select name=\"testField\" something=\"cool\"><option value=\"test\">test</option><option value=\"blue\">blue</option></select>";
		$value = $this->testClass->compile();
		$this->assertEquals($expected, $value);
	}
}