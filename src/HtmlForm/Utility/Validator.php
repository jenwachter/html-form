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

			$name = $element->name;
			$value = $element->getPostValue();

			if ($element->isRequired()) {
				$this->required($name, $value);
			}
			if ($element->isRange()) {
				$this->range($name, $value);
			}

			// run only if not a range
			if ($element->isNumber() && !$element->isRange()) {
				$this->number($name, $value);
			}
			
			if ($element->isUrl()) {
				echo $element->name . " is a url<br>";
			}
			if ($element->isEmail()) {
				echo $element->name . " is a email<br>";
			}
			if ($element->isPattern()) {
				echo $element->name . " is a pattern<br>";
			}
		}
		return $this->errors;
	}

	protected function required($name, $value)
	{
		if (empty($value)) {
			$this->errors[] = "{$name} is a required field.";
			return false;
		}
		return true;
	}

	protected function number($name, $value)
	{
		if (!is_numeric($value)) {
			$this->errors[] = "{$name} must be a number.";
			return false;
		} else {
			return true;
		}
	}

	// needs work -- the specified range needs to be passed
	protected function range($name, $value) {
		if (!is_numeric($value)) {
			$this->errors[] = "{$name} must be a number.";
			return false;
		} else {
			return true;
		}
	}
}