<?php

namespace HtmlForm\tests\Utility;

class ValidatorTest extends \HtmlForm\tests\Base
{
	public function setUp()
	{
		$this->testClass = new \HtmlForm\Utility\Validator();
		parent::setUp();
	}

	public function testFindClassWithElement()
	{
		$given = new \HtmlForm\Elements\Textbox("name", "Label");
		$expected = "textbox";

		$method = $this->getMethod("findclass");
		$result = $method->invoke($this->testClass, $given);

		$this->assertEquals($expected, $result);
	}

	public function testFindClassWithFieldset()
	{
		$given = new \HtmlForm\Fieldset("legend");
		$expected = "fieldset";

		$method = $this->getMethod("findclass");
		$result = $method->invoke($this->testClass, $given);

		$this->assertEquals($expected, $result);
	}

	public function testRequired()
	{
		// no value
		$method = $this->getMethod("required");
		$result = $method->invoke($this->testClass, "Field", "", "");
		$this->assertEquals(false, $result);

		$errorArray = array("Field is a required field.");
		$this->assertEquals($errorArray, $this->getProperty("errors"));

		// value
		$method = $this->getMethod("required");
		$result = $method->invoke($this->testClass, "Field", "Value", "");
		$this->assertEquals(true, $result);
	}
}