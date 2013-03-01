<?php

namespace HtmlForm\tests;

class FormTest extends \PHPUnit_Framework_TestCase
{
	protected $form;
	protected $reflection;

	public function setUp()
	{
		$this->form = new \HtmlForm\Form();
		$this->reflection = new \ReflectionClass("\\HtmlForm\\Form");
	}

	/**
	 * Takes care of getting the method out of the reflection class, and
	 * making it accessible to us (required for protected and private methods)
	 * 
	 * @param string $method The method you are looking to test
	 * @return ReflectionMethod
	 */
	public function getMethod($method)
	{
		$method = $this->reflection->getMethod($method);
		$method->setAccessible(true);

		return $method;
	}

	/**
	 * Takes care of getting the property out of the reflection class, and
	 * making it accessible to us (required for protected and private properties)
	 * 
	 * @param string $property The property to get
	 * @return ReflectionProperty
	 */
	public function getProperty($property)
	{
		$property = $this->reflection->getProperty($property);
		$property->setAccessible(true);

		return $property->getValue($this->form);
	}

	/**
	 * Takes care of setting the property out of the reflection class, and
	 * making it accessible to us (required for protected and private properties)
	 * 
	 * @param string $property The property to set
	 * @param string $value    The value to set
	 * @return ReflectionProperty
	 */
	public function setProperty($property, $value)
	{
		$property = $this->reflection->getProperty($property);
		$property->setAccessible(true);

		return $property->setValue($this->form, $value);
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
		$method->invoke($this->form, $given);

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
		$method->invoke($this->form, $given);

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
		$method->invoke($this->form, $given);

		$this->assertEquals($expected, $this->getProperty("config"));
	}

	public function testCompileAttributesWithNoData()
	{
		$expected = null;

		$method = $this->getMethod("compileAttributes");
		$method->invoke($this->form);

		$this->assertEquals($expected, $this->getProperty("compiledAttr"));
	}

	public function testCompileAttributesWithItems()
	{
		$given = array(
			"attr" => array(
				"class" => "one two three",
				"somethingElse" => "cool"
			)
		);

		$expected = "class=\"one two three\" somethingElse=\"cool\"";

		$this->setProperty("config", $given);

		$method = $this->getMethod("compileAttributes");
		$method->invoke($this->form, $given);

		$this->assertEquals($expected, $this->getProperty("compiledAttr"));
	}

	public function testBuildAction()
	{
		$method = $this->getMethod("buildAction");

		$action = $method->invoke($this->form);
		$this->assertEquals("index.php?test=aha", $action);
	}

	public function testBeforeElement()
	{
		$method = $this->getMethod("beforeElement");

		$element = new \stdClass();
		$element->beforeElement = "test";

		$beforeElement = $method->invoke($this->form, $element);
		$this->assertEquals("test", $beforeElement);
	}

	public function testAfterElement()
	{
		$method = $this->getMethod("afterElement");

		$element = new \stdClass();
		$element->afterElement = "test";

		$afterElement = $method->invoke($this->form, $element);
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

	public function testRender()
	{

	}

	public function testCompileErrorsWithNoErrors()
	{
		$given = array();

		$expected = null;

		$this->setProperty("validationErrors", $given);

		$method = $this->getMethod("compileErrors");

		$errors = $method->invoke($this->form);
		$this->assertEquals($expected, $errors);
	}

	public function testCompileErrorswithOneError()
	{
		$given = array("Error");

		$expected = "<div class=\"alert alert-error hfc\"><p class=\"alert-heading\">The following error was found:</p><ul><li>Error</li></ul></div>";

		$this->setProperty("validationErrors", $given);

		$method = $this->getMethod("compileErrors");

		$errors = $method->invoke($this->form);
		$this->assertEquals($expected, $errors);
	}

	public function testCompileErrorswithManyErrors()
	{
		$given = array("Error", "Error");

		$expected = "<div class=\"alert alert-error hfc\"><p class=\"alert-heading\">The following 2 errors were found:</p><ul><li>Error</li><li>Error</li></ul></div>";

		$this->setProperty("validationErrors", $given);

		$method = $this->getMethod("compileErrors");

		$errors = $method->invoke($this->form);
		$this->assertEquals($expected, $errors);
	}

	public function testRenderElements()
	{

	}
}