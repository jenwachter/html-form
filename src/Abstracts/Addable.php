<?php

namespace HtmlForm\Abstracts;

abstract class Addable
{
	/**
	 * Form elements that have been added
	 * to the form in sequencial order
	 */
	protected $elements = array();

	/**
	 * Takes care of methods like addTextbox(),
	 * addSelect(), etc...
	 * 
	 * @param  string $method Called method
	 * @param  array  $args   Arguments passed to the method
	 * @return self
	 */
	public function __call($method, $args)
	{
		if ($className = $this->findClass($method)) {
			$reflect  = new \ReflectionClass($className);
			$element = $reflect->newInstanceArgs($args);
			$this->elements[] = $element;
		} else {
			throw new \Exception("`{$method}()` does not exist on this object.");
		}
		return $this;
	}

	/**
	 * Based on a passed method name, figure out
	 * if there is a cooresponding HtmlForm element.
	 * 
	 * @param  string $method Called method
	 * @return string Class name (if there is one)
	 */
	protected function findClass($method)
	{
		if (!preg_match("/^add([a-zA-Z]+)/", $method, $matches)) {
			return false;
		}

		$className = "\\HtmlForm\\Elements\\{$matches[1]}";

		if (!class_exists($className)) {
			return false;
		}

		return $className;
	}
}