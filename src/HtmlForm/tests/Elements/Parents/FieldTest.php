<?php

namespace HtmlForm\tests\Elements\Parents;

class FieldTest extends \HtmlForm\tests\Test
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
		$this->reflection = new \ReflectionClass("\\HtmlForm\\Elements\\Parents\\Field");
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
		$expected = "<label for=\"testField\">* Test Field</label>";
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

	public function testCompileAttributesWithItems()
	{
		$given = array(
			"class" => "one two three",
			"somethingElse" => "cool"
		);
		$this->setProperty("attr", $given);
		$this->testClass->compileAttributes();

		$expected = "class=\"one two three\" somethingElse=\"cool\"";
		$this->assertEquals($expected, $this->getProperty("compiledAttr"));
	}

	public function testGetPostValue()
	{
		// Uses value assigned in constructor
		$value = $this->testClass->getPostValue();
		$this->assertEquals("test", $value);

		$this->setProperty("name", "doesNotExist");
		$value = $this->testClass->getPostValue();
		$this->assertNull($value);
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
		$this->assertEquals("*", $value);
	}
}