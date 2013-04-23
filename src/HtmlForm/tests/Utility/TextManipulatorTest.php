<?php

namespace HtmlForm\tests\Utility;

class TextManipulatorTest extends \HtmlForm\tests\Base
{
	public function setUp()
	{
		$this->testClass = new \HtmlForm\Utility\TextManipulator();
		parent::setUp();
	}

	public function testArrayToTagAttributesEmptyArray()
	{
		$this->assertEquals(null, $this->testClass->arrayToTagAttributes(array()));
	}

	public function testArrayToTagAttributes()
	{
		$given = array(
			"class" => "one two three",
			"somethingElse" => "cool"
		);

		$expected = "class=\"one two three\" somethingElse=\"cool\"";

		$result = $this->testClass->arrayToTagAttributes($given);

		$this->assertEquals($expected, $result);
	}
}