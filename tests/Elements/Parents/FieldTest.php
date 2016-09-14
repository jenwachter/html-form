<?php

namespace HtmlForm\Elements\Parents;

class FieldTest extends \HtmlForm\Base
{
	protected $testClass;
	protected $reflection;

	public function setUp()
	{
		$args = array(
			"testField",
			"Test Field",
			array(
				"required" => true
			)
		);

		$this->testClass = $this->getMockForAbstractClass("\\HtmlForm\\Elements\\Parents\\Field", $args);
		parent::setUp();
	}

	public function testConstructorSetProperties()
	{
		$this->assertEquals("testField", $this->testClass->name);
		$this->assertEquals("Test Field", $this->testClass->label);
	}

	public function testExtractArgsWithValidData()
	{
		$given = array(
			"required" => true,
			"defaultValue" => "some value"
		);

		$this->testClass->extractArgs($given);
    $this->assertEquals(true, $this->testClass->required);
	}

	public function testExtractArgsWithInvalidArgument()
	{
		$this->setExpectedException("InvalidArgumentException");
		$test = $this->testClass->extractArgs(array("test" => "test"));
	}

	public function testCompileLabelWithGivenArgs()
	{
		// Method already ran in constructor, so no need to run again
		$expected = "<label for=\"testField\"><span class='required'>*</span> Test Field</label>";
		$this->assertEquals($expected, $this->testClass->compiledLabel);
	}

	public function testCompileLabelWithNoRequired()
	{
		$this->setProperty("required", false);
		$this->testClass->compileLabel();

		$expected = "<label for=\"testField\">Test Field</label>";
		$this->assertEquals($expected, $this->testClass->compiledLabel);

	}

	public function testCompileAttributesWithNoData()
	{
		// Method already ran in constructor, so no need to run again
		$expected = null;
		$this->assertEquals($expected, $this->testClass->compiledAttr);
	}

	public function testgetRawValue()
	{
		// Uses value assigned in constructor
		$value = $this->testClass->getRawValue();
		$this->assertEquals("test", $value);

		$this->setProperty("name", "doesNotExist");
		$value = $this->testClass->getRawValue();
		$this->assertNull($value);
	}

	public function testGetDisplayValue()
	{
		$method = $this->getMethod("getDisplayValue");

		// // if nothing set
		// $result = $method->invoke($this->testClass);
		// $this->assertEquals("default", $result);

		// if set in $_POST
		$_POST["testField"] = "hi";
		$result = $method->invoke($this->testClass);
		$this->assertEquals("hi", $result);

		// // if set in $_SESSION
		// $this->setProperty("formid", "theformid");
		// $_SESSION["theformid"]["testField"] = "hello";
		// $result = $method->invoke($this->testClass);
		// $this->assertEquals("hello", $result);
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

	public function testIsPattern()
	{
		$value = $this->testClass->isPattern();
		$this->assertFalse($value);

		$this->setProperty("attr", array("pattern" => "[a-z]+"));
		$value = $this->testClass->isPattern();
		$this->assertTrue($value);
	}

	public function test__Get()
	{
		$value = $this->testClass->requiredSymbol;
		$this->assertEquals("<span class='required'>*</span>", $value);
	}
}
