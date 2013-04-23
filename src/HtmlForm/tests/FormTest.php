<?php

namespace HtmlForm\tests;

class FormTest extends Base
{
	protected $testClass;
	protected $reflection;

	public function setUp()
	{
		$this->testClass = new \HtmlForm\Form();
		$this->reflection = new \ReflectionClass("\\HtmlForm\\Form");
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

	// public function testCompileAttributesWithNoData()
	// {
	// 	$expected = null;

	// 	$method = $this->getMethod("compileAttributes");
	// 	$method->invoke($this->testClass);

	// 	$this->assertEquals($expected, $this->getProperty("compiledAttr"));
	// }

	// public function testCompileAttributesWithItems()
	// {
	// 	$given = array(
	// 		"attr" => array(
	// 			"class" => "one two three",
	// 			"somethingElse" => "cool"
	// 		)
	// 	);

	// 	$expected = "class=\"one two three\" somethingElse=\"cool\"";

	// 	$this->setProperty("config", $given);

	// 	$method = $this->getMethod("compileAttributes");
	// 	$method->invoke($this->testClass, $given);

	// 	$this->assertEquals($expected, $this->getProperty("compiledAttr"));
	// }

	public function testBuildAction()
	{
		$method = $this->getMethod("buildAction");

		$action = $method->invoke($this->testClass);
		$this->assertEquals("index.php?test=aha", $action);
	}

	public function testBeforeElement()
	{
		$method = $this->getMethod("beforeElement");

		$element = new \stdClass();
		$element->beforeElement = "test";

		$beforeElement = $method->invoke($this->testClass, $element);
		$this->assertEquals("test", $beforeElement);
	}

	public function testAfterElement()
	{
		$method = $this->getMethod("afterElement");

		$element = new \stdClass();
		$element->afterElement = "test";

		$afterElement = $method->invoke($this->testClass, $element);
		$this->assertEquals("test", $afterElement);
	}

	public function testCall()
	{

	}

	public function testIsValid()
	{

	}

	public function testSaveToSession()
	{

	}

	public function testGetValue()
	{
		
	}

	public function testCompileForm()
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

		$this->setProperty("formElements", array($field));

		$expected = "<div class=\"alert alert-error test\"><p class=\"alert-heading\">The following error was found:</p><ul><li>first name is a required field.</li></ul></div><form novalidate=\"novalidate\" method=\"get\" action=\"some_page.php\" id=\"test\" blah=\"blah\"><div class=\"form_field clearfix\"><label for=\"firstName\">* first name</label><input type=\"text\" name=\"firstName\"  value=\"\" /></div></form>";
		
		$method = $this->getMethod("compileForm");

		$result = $method->invoke($this->testClass);

		$this->assertEquals($expected, $result);

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
		$field = new \HtmlForm\Elements\Textbox("firstName", "first name", array(
			"required" => true,
			"beforeElement" => "<div class=\"form_field clearfix\">",
			"afterElement" => "</div>"
		));

		$this->setProperty("formElements", array($field));
		$expected = "<div class=\"form_field clearfix\"><label for=\"firstName\">* first name</label><input type=\"text\" name=\"firstName\"  value=\"\" /></div>";
		
		$method = $this->getMethod("renderElements");

		$result = $method->invoke($this->testClass);

		$this->assertEquals($expected, $result);
	}
}