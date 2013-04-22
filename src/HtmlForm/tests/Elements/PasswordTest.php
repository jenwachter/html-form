<?php

namespace HtmlForm\tests\Elements;

class PasswordTest extends \HtmlForm\tests\Test
{
	protected $testClass;
	protected $reflection;

	public function setUp()
	{
		$this->testClass = new \HtmlForm\Elements\Password("testField", "Test Field");
		$this->reflection = new \ReflectionClass("\\HtmlForm\\Elements\\Password");
	}

	public function testType()
	{
		$this->assertEquals("password", $this->testClass->type);
	}

	public function testCompile()
	{
		$expected = "<label for=\"testField\">Test Field</label><input type=\"password\" name=\"testField\"  value=\"\" />";
		$this->assertEquals($expected, $this->testClass->compile());
	}
}