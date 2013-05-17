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

	public function testSetConfigWithUserAction()
	{
		$given = array(
			"action" => "otherPage.php"
		);

		$expected = array(
			"method" => "post",
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

	public function testSetConfigWithAllUserData()
	{
		$given = $expected = array(
			"method" => "get",
			"action" => "otherPage.php",
			"id" => "myForm",
			"repopulate" => false,
			"attr" => array("class" => "one two"),
			"beforeElement" => "<div>",
			"afterElement" => "</div>"
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

	public function testSaveToSession()
	{

	}

	public function testGetValue()
	{
		$method = $this->getMethod("getValue");

		$result = $method->invoke($this->testClass, $this->mocks["textbox"]);
		$this->assertEquals("default", $result);

		$_POST["name"] = "hi";
		$result = $method->invoke($this->testClass, $this->mocks["textbox"]);
		$this->assertEquals("hi", $result);

		$this->setProperty("config", array("id" => "testing"));
		$_SESSION["testing"]["name"] = "hello";
		$result = $method->invoke($this->testClass, $this->mocks["textbox"]);
		$this->assertEquals("hello", $result);
	}

	public function testCleanValue()
	{
		$method = $this->getMethod("cleanValue");

		$given = "Something\'s gotta give";
		$expected = "Something's gotta give";
		$result = $method->invoke($this->testClass, $given);
		$this->assertEquals($expected, $result);

		$given = array("Something\'s gotta give", "You can\'t tell Erol anything");
		$expected = array("Something's gotta give", "You can't tell Erol anything");
		$result = $method->invoke($this->testClass, $given);
		$this->assertEquals($expected, $result);
	}

	public function testDisplay()
	{

	}

	public function testRender()
	{
		$config = array(
			"id" => "test",
			"method" => "get",
			"action" => "some_page.php"
		);
		$this->setProperty("config", $config);
		$this->setProperty("compiledAttr", "blah=\"blah\"");

		$this->setProperty("validationErrors", array("first name is a required field."));

		$field = new \HtmlForm\Elements\Textbox("firstName", "first name", array(
			"required" => true,
			"beforeElement" => "<div class=\"form_field clearfix\">",
			"afterElement" => "</div>"
		));

		$this->setProperty("elements", array($field));

		$expected = "<div class=\"alert alert-error test\"><p class=\"alert-heading\">The following error was found:</p><ul><li>first name is a required field.</li></ul></div><form novalidate=\"novalidate\" method=\"get\" action=\"some_page.php\" id=\"test\" blah=\"blah\"><div class=\"form_field clearfix\"><label for=\"firstName\">* first name</label><input type=\"text\" name=\"firstName\"  value=\"\" /></div></form>";
		
		$method = $this->getMethod("render");

		$result = $method->invoke($this->testClass);

		$this->assertEquals($expected, $result);

	}

	public function testGetOpeningTag()
	{

	}

	public function testGetClosingTag()
	{

	}

	public function testCompileErrorsWithNoErrors()
	{
		$given = array();

		$expected = null;

		$this->setProperty("validationErrors", $given);

		$method = $this->getMethod("compileErrors");

		$errors = $method->invoke($this->testClass);
		$this->assertEquals($expected, $errors);
	}

	public function testCompileErrorswithOneError()
	{
		$given = array("Error");

		$expected = "<div class=\"alert alert-error hfc\"><p class=\"alert-heading\">The following error was found:</p><ul><li>Error</li></ul></div>";

		$this->setProperty("validationErrors", $given);

		$method = $this->getMethod("compileErrors");

		$errors = $method->invoke($this->testClass);
		$this->assertEquals($expected, $errors);
	}

	public function testCompileErrorswithManyErrors()
	{
		$given = array("Error", "Error");

		$expected = "<div class=\"alert alert-error hfc\"><p class=\"alert-heading\">The following 2 errors were found:</p><ul><li>Error</li><li>Error</li></ul></div>";

		$this->setProperty("validationErrors", $given);

		$method = $this->getMethod("compileErrors");

		$errors = $method->invoke($this->testClass);
		$this->assertEquals($expected, $errors);
	}

	public function testRenderElements()
	{
		// add fieldset
		$fieldset = new \HtmlForm\Fieldset("The Legend");
		$fieldset->elements[] = new \HtmlForm\Elements\Textbox("firstName", "first name", array(
			"required" => true,
			"beforeElement" => "<div class=\"form_field clearfix\">",
			"afterElement" => "</div>"
		));

		$this->setProperty("elements", array($fieldset));
		$expected = "<form novalidate=\"novalidate\" method=\"post\" action=\"index.php?test=aha\" id=\"hfc\" ><fieldset><legend>The Legend</legend><div class=\"form_field clearfix\"><label for=\"firstName\">* first name</label><input type=\"text\" name=\"firstName\"  value=\"\" /></div></fieldset></form>";
		
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