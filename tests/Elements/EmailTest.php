<?php

namespace HtmlForm\Elements;

class EmailTest extends \HtmlForm\Base
{
	protected $testClass;
	protected $reflection;

	public function setUp()
	{
		$this->testClass = new \HtmlForm\Elements\Email("testField", "Test Field");
		parent::setUp();
	}

	public function testType()
	{
		$this->assertEquals("email", $this->testClass->type);
	}

	public function testCompile()
	{
		$expected = "<label for=\"testField\">Test Field</label><input type=\"email\" name=\"testField\"  value=\"\" />";
		$this->assertEquals($expected, $this->testClass->compile());
	}
}