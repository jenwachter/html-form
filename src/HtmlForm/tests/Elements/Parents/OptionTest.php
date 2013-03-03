<?php

namespace HtmlForm\tests\Elements\Parents;

class OptionTest extends \HtmlForm\tests\Test
{
	protected $testClass;
	protected $reflection;

	public function setUp()
	{
		$args = array(
			"testField",
			"Test Field",
			array(
				"test", "blue"
			)
		);

		$this->testClass = $this->getMockForAbstractClass("\\HtmlForm\\Elements\\Parents\\Option", $args);
		$this->reflection = new \ReflectionClass("\\HtmlForm\\Elements\\Parents\\Option");
	}

	public function testConstructorSetProperties()
	{
		$expected = array(
			"test", "blue"
		);
		$this->assertEquals($expected, $this->testClass->options);
	}

	public function testHasOptionValue()
	{
		$method = $this->getMethod("hasOptionValue");

		$given = array("test", "blue");
		$value = $method->invoke($this->testClass, $given);
		$this->assertFalse($value);

		$given = array("test" => "test", "blue" => "blue");
		$value = $method->invoke($this->testClass, $given);
		$this->assertTrue($value);
	}

	// public function testCompileAsRadioWithNoOptionValue()
	// {
	// 	$this->setProperty("type", "radio");

	// 	$expected = "<input type=\"radio\" name=\"testField[]\" value=\"test\" checked=\"checked\" /> test<input type=\"radio\" name=\"testField[]\" value=\"blue\" /> blue";
	// 	$value = $this->testClass->compile();
	// 	$this->assertEquals($expected, $value);
	// }
}