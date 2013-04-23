<?php

namespace HtmlForm\tests\Elements;

class HiddenTest extends \HtmlForm\tests\Base
{
	protected $testClass;
	protected $reflection;

	public function setUp()
	{
		$this->testClass = new \HtmlForm\Elements\Hidden("testField", "Test Field");
		parent::setUp();
	}

	public function testType()
	{
		$this->assertEquals("hidden", $this->testClass->type);
	}

	public function testCompile()
	{
		$expected = "<input type=\"hidden\" name=\"testField\"  value=\"\" />";
		$this->assertEquals($expected, $this->testClass->compile());
	}
}