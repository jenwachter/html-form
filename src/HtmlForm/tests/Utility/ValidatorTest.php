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

	public function testCompileErrorsWithNoErrors()
	{
		$given = array();
		$expected = null;
		$this->setProperty("errors", $given);

		$errors = $this->testClass->renderErrors();
		$this->assertEquals($expected, $errors);
	}

	public function testCompileErrorswithOneError()
	{
		$given = array("Error");
		$expected = "<div class=\"alert alert-error\"><p class=\"alert-heading\">The following error was found:</p><ul><li>Error</li></ul></div>";
		$this->setProperty("errors", $given);

		$errors = $this->testClass->renderErrors();
		$this->assertEquals($expected, $errors);
	}

	public function testCompileErrorswithManyErrors()
	{
		$given = array("Error", "Error");
		$expected = "<div class=\"alert alert-error\"><p class=\"alert-heading\">The following 2 errors were found:</p><ul><li>Error</li><li>Error</li></ul></div>";
		$this->setProperty("errors", $given);

		$errors = $this->testClass->renderErrors();
		$this->assertEquals($expected, $errors);
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

	public function testPushError()
	{
		$method = $this->getMethod("pushError");

		$given = "Field is a required field.";
		$method->invoke($this->testClass, $given);

		$this->assertContains($given, $this->getProperty("errors"));
	}

	public function testRequired()
	{
		$method = $this->getMethod("required");

		// no value
		$result = $method->invoke($this->testClass, "Field", "", "");
		$this->assertFalse($result);

		// value
		$result = $method->invoke($this->testClass, "Field", "Value", "");
		$this->assertTrue($result);
	}

	public function testNumber()
	{
		$method = $this->getMethod("number");

		// not a number
		$result = $method->invoke($this->testClass, "Field", "three", "");
		$this->assertFalse($result);

		// number
		$result = $method->invoke($this->testClass, "Field", 3, "");
		$this->assertTrue($result);

		// number like
		$result = $method->invoke($this->testClass, "Field", "3", "");
		$this->assertTrue($result);
	}

	public function testRange()
	{
		$method = $this->getMethod("range");

		// not a number
		$result = $method->invoke($this->testClass, "Field", "three", $this->mocks["range"]);
		$this->assertFalse($result);

		// number, but not in range
		$result = $method->invoke($this->testClass, "Field", 15, $this->mocks["range"]);
		$this->assertFalse($result);

		// number, in range
		$result = $method->invoke($this->testClass, "Field", 7, $this->mocks["range"]);
		$this->assertTrue($result);
	}

	public function testUrl()
	{
		$method = $this->getMethod("url");

		// not a url
		$result = $method->invoke($this->testClass, "Field", "Not a URL", "");
		$this->assertFalse($result);

		$result = $method->invoke($this->testClass, "Field", "www.google.com", "");
		$this->assertFalse($result);

		$result = $method->invoke($this->testClass, "Field", "google.com", "");
		$this->assertFalse($result);

		// valid url
		$result = $method->invoke($this->testClass, "Field", "http://google.com", "");
		$this->assertTrue($result);

	}

	public function testEmail()
	{
		$method = $this->getMethod("email");

		// not an email
		$result = $method->invoke($this->testClass, "Field", "Not an email", "");
		$this->assertFalse($result);

		// valid email
		$result = $method->invoke($this->testClass, "Field", "test@test.test", "");
		$this->assertTrue($result);
	}

	public function testPattern()
	{
		$method = $this->getMethod("pattern");

		// does not match
		$result = $method->invoke($this->testClass, "Field", "Not a match", $this->mocks["textbox"]);
		$this->assertFalse($result);

		// matches
		$result = $method->invoke($this->testClass, "Field", 5, $this->mocks["textbox"]);
		$this->assertTrue($result);

		$result = $method->invoke($this->testClass, "Field", "5", $this->mocks["textbox"]);
		$this->assertTrue($result);
	}

	public function testHoneypot()
	{
		$method = $this->getMethod("honeypot");

		$result = $method->invoke($this->testClass, "Field", "Value", "");
		$this->assertFalse($result);

		$result = $method->invoke($this->testClass, "Field", null, "");
		$this->assertTrue($result);
	}

}