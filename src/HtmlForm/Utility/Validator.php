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

			$label = $element->label;
			$value = $element->getPostValue();

			if ($element->isRequired()) {
				$this->required($label, $value);
			}
			if ($element->isRange()) {
				$this->range($label, $value, $element);
			}

			// run only if not a range
			if (!$element->isRange() && $element->isNumber()) {
				$this->number($label, $value);
			}
			
			if ($element->isUrl()) {
				$this->url($label, $value);
			}
			if ($element->isEmail()) {
				$this->email($label, $value);
			}
			if ($element->isPattern()) {
				$this->pattern($label, $value, $element);
			}
		}
		return $this->errors;
	}

	protected function required($label, $value)
	{
		if (empty($value)) {
			$this->errors[] = "{$label} is a required field.";
			return false;
		}

		return true;
	}

	protected function number($label, $value)
	{
		if (!is_numeric($value)) {
			$this->errors[] = "{$label} must be a number.";
			return false;
		}

		return true;
	}

	protected function range($label, $value, $element)
	{
		$min = $element->attr["min"];
		$max = $element->attr["max"];

		if (!is_numeric($value)) {
			$this->errors[] = "{$label} must be a number.";
			return false;
		}

		if ($value < $min || $value > $max) {
			$this->errors[] = "{$label} must be a number between {$min} and {$max}.";
			return false;
		}

		return true;
	}

	protected function url($label, $value)
	{
		if (!filter_var($value, FILTER_VALIDATE_URL)) {
			$this->errors[] = "{$label} must be a valid URL.";
		}

		return true;
	}

	protected function email($label, $value)
	{
		if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
			$this->errors[] = "{$label} must be a valid email address.";
		}

		return true;
	}

	// needs a better error message
	protected function pattern($label, $value, $element)
	{
		$pattern = $element->attr["pattern"];

		if (!preg_match("/{$pattern}/", $value)) {
			$this->errors[] = "{$label} must be match the specificed pattern.";
			return false;
		}

		return true;
	}
}