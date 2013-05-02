<?php

namespace HtmlForm\tests\Elements;

class RadioTest extends \HtmlForm\tests\Base
{
	protected $testClass;
	protected $reflection;

	public function setUp()
	{
		$this->testClass = new \HtmlForm\Elements\Radio("testField", "Test Field", array("test", "blue"));
		parent::setUp();
	}

	public function testType()
	{
		$this->assertEquals("radio", $this->testClass->type);
	}

	public function testCompileWithNoOptionValue()
	{
		$expected = "<label for=\"testField\">Test Field</label><div class=\"elements\"><div class=\"element\"><input type=\"radio\"  name=\"testField\" value=\"test\"  /> <span>test</span></div><div class=\"element\"><input type=\"radio\"  name=\"testField\" value=\"blue\"  /> <span>blue</span></div></div>";
		$value = $this->testClass->compile();
		$this->assertEquals($expected, $value);
	}

	public function testCompileWithOptionValue()
	{
		$this->setProperty("options", array("one" => "test", "two" => "blue"));
		$expected = "<label for=\"testField\">Test Field</label><div class=\"elements\"><div class=\"element\"><input type=\"radio\"  name=\"testField\" value=\"one\"  /> <span>test</span></div><div class=\"element\"><input type=\"radio\"  name=\"testField\" value=\"two\"  /> <span>blue</span></div></div>";
		$value = $this->testClass->compile();
		$this->assertEquals($expected, $value);
	}

	public function testCompileWithValue()
	{
		$expected = "<label for=\"testField\">Test Field</label><div class=\"elements\"><div class=\"element\"><input type=\"radio\"  name=\"testField\" value=\"test\" checked=\"checked\" /> <span>test</span></div><div class=\"element\"><input type=\"radio\"  name=\"testField\" value=\"blue\"  /> <span>blue</span></div></div>";
		$value = $this->testClass->compile("test");
		$this->assertEquals($expected, $value);
	}

	public function testCompileWithAttr()
	{
		$this->setProperty("compiledAttr", "something=\"cool\"");

		$expected = "<label for=\"testField\">Test Field</label><div class=\"elements\"><div class=\"element\"><input type=\"radio\" something=\"cool\" name=\"testField\" value=\"test\" checked=\"checked\" /> <span>test</span></div><div class=\"element\"><input type=\"radio\" something=\"cool\" name=\"testField\" value=\"blue\"  /> <span>blue</span></div></div>";
		$value = $this->testClass->compile("test");
		$this->assertEquals($expected, $value);
	}
}