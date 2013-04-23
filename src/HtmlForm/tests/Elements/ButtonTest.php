<?php

namespace HtmlForm\tests\Elements;

class ButtonTest extends \HtmlForm\tests\Base
{
	protected $testClass;
	protected $reflection;

	public function setUp()
	{
		$this->testClass = new \HtmlForm\Elements\Button("testField", "Test Field");
		parent::setUp();
	}

	public function testType()
	{
		$this->assertEquals("button", $this->testClass->type);
	}

	public function testCompile()
	{
		$expected = "<input type=\"button\" name=\"testField\"  value=\"Test Field\" />";
		$this->assertEquals($expected, $this->testClass->compile());
	}

	public function testCompileWithAttr()
	{
		$this->setProperty("compiledAttr", "something=\"cool\"");
		
		$expected = "<input type=\"button\" name=\"testField\" something=\"cool\" value=\"Test Field\" />";
		$this->assertEquals($expected, $this->testClass->compile());
	}
}