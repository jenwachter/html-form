<?php

namespace HtmlForm\tests\Utility;

class ValidatorTest extends \HtmlForm\tests\Base
{
	public function setUp()
	{
		$this->testClass = new \HtmlForm\Utility\Validator();
		parent::setUp();

		$this->mocks = array(
			"textbox" => $this->getMock("\\HtmlForm\\Elements\\Textbox", array("compileLabel"), array("name", "label", array("attr" => array("pattern" => "/\d{1,3}/")))),
			"range" => $this->getMock("\\HtmlForm\\Elements\\Range", array("compileLabel"), array("name", "label", 5, 10))
		);
	}

	public function testValidate()
	{
		$method = $this->getMethod("validate");

		$result = $method->invoke($this->testClass, "");
		$this->assertEquals(false, $result);

		$result = $method->invoke($this->testClass, new \StdClass());
		$this->assertEquals(false, $result);
	}

	public function testFindClassWithElement()
	{
		// cannot use a mock object here because the class name comes back as a mock
		$given = new \HtmlForm\Elements\Textbox("name", "Label");
		$expected = "textbox";

		$method = $this->getMethod("findclass");
		$result = $method->invoke($this->testClass, $given);

		$this->assertEquals($expected, $result);
	}

	public function testFindClassWithFieldset()
	{
		// cannot use a mock object here because the class name comes back as a mock
		$given = new \HtmlForm\Fieldset("legend");
		$expected = "fieldset";

		$method = $this->getMethod("findclass");
		$result = $method->invoke($this->testClass, $given);

		$this->assertEquals($expected, $result);
	}

	public function testRequired()
	{
		$method = $this->getMethod("required");

		// no value
		$result = $method->invoke($this->testClass, "Field", "", "");
		$this->assertEquals(false, $result);
		$errorArray = array("Field is a required field.");
		$this->assertEquals($errorArray, $this->getProperty("errors"));

		// value
		$result = $method->invoke($this->testClass, "Field", "Value", "");
		$this->assertEquals(true, $result);
	}

	public function testNumber()
	{
		$method = $this->getMethod("number");

		// not a number
		$result = $method->invoke($this->testClass, "Field", "three", "");
		$this->assertEquals(false, $result);
		$errorArray = array("Field must be a number.");
		$this->assertEquals($errorArray, $this->getProperty("errors"));

		// number
		$result = $method->invoke($this->testClass, "Field", 3, "");
		$this->assertEquals(true, $result);

		$result = $method->invoke($this->testClass, "Field", "3", "");
		$this->assertEquals(true, $result);
	}

	public function testRange()
	{
		$method = $this->getMethod("range");

		// not a number
		$result = $method->invoke($this->testClass, "Field", "three", $this->mocks["range"]);
		$this->assertEquals(false, $result);

		$this->setProperty("errors", array());

		// number, but not in range
		$result = $method->invoke($this->testClass, "Field", 15, $this->mocks["range"]);
		$this->assertEquals(false, $result);
		$errorArray = array("Field must be a number between 5 and 10.");
		$this->assertEquals($errorArray, $this->getProperty("errors"));

		$this->setProperty("errors", array());
		

		// number, in range
		$result = $method->invoke($this->testClass, "Field", 7, $this->mocks["range"]);
		$this->assertEquals(true, $result);
	}

	public function testUrl()
	{
		$method = $this->getMethod("url");

		// not a url
		$result = $method->invoke($this->testClass, "Field", "Not a URL", "");
		$this->assertEquals(false, $result);
		$errorArray = array("Field must be a valid URL.");
		$this->assertEquals($errorArray, $this->getProperty("errors"));

		$result = $method->invoke($this->testClass, "Field", "www.google.com", "");
		$this->assertEquals(false, $result);

		$result = $method->invoke($this->testClass, "Field", "google.com", "");
		$this->assertEquals(false, $result);

		// valid url
		$result = $method->invoke($this->testClass, "Field", "http://google.com", "");
		$this->assertEquals(true, $result);

	}

	public function testEmail()
	{
		$method = $this->getMethod("email");

		// not an email
		$result = $method->invoke($this->testClass, "Field", "Not an email", "");
		$this->assertEquals(false, $result);
		$errorArray = array("Field must be a valid email address.");
		$this->assertEquals($errorArray, $this->getProperty("errors"));


		// valid email
		$result = $method->invoke($this->testClass, "Field", "test@test.test", "");
		$this->assertEquals(true, $result);
	}

	public function testPattern()
	{
		$method = $this->getMethod("pattern");

		// does not match
		$result = $method->invoke($this->testClass, "Field", "Not a match", $this->mocks["textbox"]);
		$this->assertEquals(false, $result);
		$errorArray = array("Field must be match the specificed pattern.");
		$this->assertEquals($errorArray, $this->getProperty("errors"));

		// matches
		$result = $method->invoke($this->testClass, "Field", 5, $this->mocks["textbox"]);
		$this->assertEquals(true, $result);

		$result = $method->invoke($this->testClass, "Field", "5", $this->mocks["textbox"]);
		$this->assertEquals(true, $result);
	}

	public function testHoneypot()
	{
		$method = $this->getMethod("honeypot");

		$result = $method->invoke($this->testClass, "Field", "Value", "");
		$this->assertEquals(false, $result);

		$result = $method->invoke($this->testClass, "Field", null, "");
		$this->assertEquals(true, $result);
	}

}