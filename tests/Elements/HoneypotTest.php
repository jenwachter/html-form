<?php

namespace HtmlForm\Elements\Parents;

class HoneypotTest extends \HtmlForm\Base
{
	protected $testClass;
	protected $reflection;

	public function setUp()
	{
		$this->testClass = new \HtmlForm\Elements\Honeypot("testField", "Test Field");
		parent::setUp();
	}

	public function testType()
	{
		$this->assertEquals("text", $this->testClass->type);
	}

	public function testCompile()
	{
		$expected = "<div class=\"honeypot\" style=\"display: none;\"><input type=\"text\" name=\"testField\"  value=\"\" /></div>";
		$this->assertEquals($expected, $this->testClass->compile());
	}
}
