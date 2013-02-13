<?php

namespace HtmlForm\Utility;

class Validator
{
	/**
	 * Form element objects
	 * @var array
	 */
	protected $elements = array();

	/**
	 * Found errors
	 * @var array
	 */
	protected $errors = array();

	public function __construct($elements)
	{
		$this->elements = $elements;
	}

	public function validate()
	{
		foreach ($this->elements as $element) {
			if ($element->isRequired()) {
				$this->required($element);
			}
		}
		return $this->errors;
	}

	protected function required($element)
	{
		$name = $element->getName();
		if (empty($_POST[$name])) {
			$this->errors[] = "{$name} is a required field.";
		}
	}

	protected function pattern($element)
	{

	}
}