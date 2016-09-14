<?php

namespace HtmlForm\Elements;

class PasswordTest extends \HtmlForm\Base
{
	protected $testClass;
	protected $reflection;

	public function setUp()
	{
		$this->testClass = new \HtmlForm\Elements\Password("testField", "Test Field");
		parent::setUp();
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