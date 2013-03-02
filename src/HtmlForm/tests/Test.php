<?php

namespace HtmlForm\tests;

class Test extends \PHPUnit_Framework_TestCase
{
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

		return $property->getValue($this->testClass);
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

		return $property->setValue($this->testClass, $value);
	}
}