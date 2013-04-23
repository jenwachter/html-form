<?php

namespace HtmlForm\tests\Elements\Parents;

class OptionTest extends \HtmlForm\tests\Base
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
}