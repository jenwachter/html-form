<?php

namespace HtmlForm\Elements\Parents;

class OptionTest extends \HtmlForm\Base
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
		parent::setUp();
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