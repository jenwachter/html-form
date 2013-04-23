<?php

namespace HtmlForm\tests\Elements;

class SubmitTest extends \HtmlForm\tests\Base
{
	protected $testClass;
	protected $reflection;

	public function setUp()
	{
		$this->testClass = new \HtmlForm\Elements\Submit("testField", "Test Field");
		$this->reflection = new \ReflectionClass("\\HtmlForm\\Elements\\Submit");
	}

	public function testType()
	{
		$this->assertEquals("submit", $this->testClass->type);
	}

	public function testCompile()
	{
		$expected = "<input type=\"submit\" name=\"testField\"  value=\"Test Field\" />";
		$this->assertEquals($expected, $this->testClass->compile());
	}

	public function testCompileWithAttr()
	{
		$this->setProperty("compiledAttr", "something=\"cool\"");
		
		$expected = "<input type=\"submit\" name=\"testField\" something=\"cool\" value=\"Test Field\" />";
		$this->assertEquals($expected, $this->testClass->compile());
	}
}