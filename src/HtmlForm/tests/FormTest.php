<?php

namespace HtmlForm\tests;

class FormTest extends Base
{
	protected $testClass;

	public function setUp()
	{
		$this->testClass = new \HtmlForm\Form();
		parent::setUp();

		$this->mocks = array(
			"textbox" => $this->getMock("\\HtmlForm\\Elements\\Textbox", array("compileLabel"), array("name", "label", array(
				"beforeElement" => "<div class=\"before\">",
				"afterElement" => "</div>",
				"defaultValue" => "default"
			)))
		);
	}

	public function testBuildAction()
	{

	}

	public function testSetConfigWithNoUserConfig()
	{
		$given = array();

		$expected = array(
			"method" => "post",
			"action" => "index.php?test=aha",
			"id" => "hfc",
			"repopulate" => true,
			"attr" => array(),
			"beforeElement" => "",
			"afterElement" => ""
		);

		$method = $this->getMethod("setConfig");
		$method->invoke($this->testClass, $given);

		$this->assertEquals($expected, $this->getProperty("config"));
	}

	public function testSetConfigWithData()
	{
		$given = array(
			"action" => "otherPage.php",
			"method" => "get"
		);

		$expected = array(
			"method" => "get",
			"action" => "otherPage.php",
			"id" => "hfc",
			"repopulate" => true,
			"attr" => array(),
			"beforeElement" => "",
			"afterElement" => ""
		);

		$method = $this->getMethod("setConfig");
		$method->invoke($this->testClass, $given);

		$this->assertEquals($expected, $this->getProperty("config"));
	}

	public function testBeforeElement()
	{
		$method = $this->getMethod("beforeElement");

		$beforeElement = $method->invoke($this->testClass, $this->mocks["textbox"]);
		$this->assertEquals("<div class=\"before\">", $beforeElement);
	}

	public function testAfterElement()
	{
		$method = $this->getMethod("afterElement");

		$afterElement = $method->invoke($this->testClass, $this->mocks["textbox"]);
		$this->assertEquals("</div>", $afterElement);
	}

	public function testAddHoneypot()
	{

	}

	public function testAddFieldset()
	{

	}

	public function testIsValid()
	{

	}

	public function testPassedHoneypot()
	{

	}

	public function testSetErrorMessage()
	{
		$given = "My custom error.";
		$this->testClass->setErrorMessage($given);

		$validator = $this->getProperty("validator");
		$this->assertContains($given, $validator->errors);
	}

	public function testSaveToSession()
	{

	}

	public function testGetValue()
	{
		$method = $this->getMethod("getValue");

		// if nothing set
		$result = $method->invoke($this->testClass, $this->mocks["textbox"]);
		$this->assertEquals("default", $result);

		// if set in $_POST
		$_POST["name"] = "hi";
		$result = $method->invoke($this->testClass, $this->mocks["textbox"]);
		$this->assertEquals("hi", $result);

		// if set in $_SESSION
		$this->setProperty("config", array("id" => "testing"));
		$_SESSION["testing"]["name"] = "hello";
		$result = $method->invoke($this->testClass, $this->mocks["textbox"]);
		$this->assertEquals("hello", $result);
	}

	public function testCleanValue()
	{
		$method = $this->getMethod("cleanValue");

		$given = "Something\'s gotta give";
		$expected = stripslashes($given);
		$result = $method->invoke($this->testClass, $given);
		$this->assertEquals($expected, $result);

		$given = array($given);
		$expected = array($expected);
		$result = $method->invoke($this->testClass, $given);
		$this->assertEquals($expected, $result);
	}

	public function testDisplay()
	{

	}

	public function testRender()
	{

	}

	public function testGetOpeningTag()
	{

	}

	public function testGetClosingTag()
	{
		$method = $this->getMethod("getClosingTag");
		$result = $method->invoke($this->testClass);
		$this->assertEquals("</form>", $result);
	}

	public function testRenderElementsWithAddable()
	{
		// add fieldset
		$fieldset = new \HtmlForm\Fieldset("The Legend");
		$fieldset->elements[] = new \HtmlForm\Elements\Textbox("firstName", "first name", array(
			"required" => true,
			"beforeElement" => "<div class=\"form_field clearfix\">",
			"afterElement" => "</div>"
		));

		$this->setProperty("elements", array($fieldset));
		$expected = "<form method=\"post\" action=\"index.php?test=aha\" id=\"hfc\" ><fieldset><legend>The Legend</legend><div class=\"form_field clearfix\"><label for=\"firstName\"><span class='required'>*</span> first name</label><input type=\"text\" name=\"firstName\"  value=\"\" /></div></fieldset></form>";

		$method = $this->getMethod("renderElements");

		$result = $method->invoke($this->testClass, $this->testClass);

		$this->assertEquals($expected, $result);
	}

	public function testRenderElementsWithoutAddable()
	{
		$method = $this->getMethod("renderElements");

		$result = $method->invoke($this->testClass, array());

		$this->assertEquals(null, $result);
	}
}
