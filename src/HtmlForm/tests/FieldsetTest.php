<?php

namespace HtmlForm\tests;

class FieldsetTest extends Base
{
	protected $testClass;

	public function setUp()
	{
		$this->testClass = new \HtmlForm\Fieldset();
		parent::setUp();
	}

	public function testGetOpeningTag()
	{
		$this->setProperty("legend", "Testing");
		$result = $this->testClass->getOpeningTag();
		$this->assertEquals("<fieldset><legend>Testing</legend>", $result);
	}

	public function testGetClosingTag()
	{
		$result = $this->testClass->getClosingTag();
		$this->assertEquals("</fieldset>", $result);
	}
}