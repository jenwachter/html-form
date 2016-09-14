<?php

namespace HtmlForm\Abstracts;

class AddableTest extends \HtmlForm\Base
{
	public function setUp()
	{
		$this->testClass = $this->getMockForAbstractClass("\\HtmlForm\\Abstracts\\Addable");
		parent::setUp();
	}

	public function testCall()
	{
		
	}

	public function testFindClassThatExists()
	{	
		$given = "addTextbox";
		$expected = "\HtmlForm\Elements\Textbox";

		$method = $this->getMethod("findClass");
		$result = $method->invoke($this->testClass, $given);

		$this->assertEquals($expected, $result);
	}

	public function testFindClassThatDoesntExists()
	{	
		$given = "addSomething";
		$expected = null;

		$method = $this->getMethod("findClass");
		$result = $method->invoke($this->testClass, $given);

		$this->assertEquals($expected, $result);
	}

	public function testFindClassIncorrectMethod()
	{	
		$given = "something";
		$expected = null;

		$method = $this->getMethod("findClass");
		$result = $method->invoke($this->testClass, $given);

		$this->assertEquals($expected, $result);
	}
}