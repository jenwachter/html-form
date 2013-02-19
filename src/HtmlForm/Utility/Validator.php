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
			$class = $this->findclass($element);

			// Run validation against class
			if (method_exists($this, $class)) {
				$this->$class($label, $value, $element);
			}

			if ($element->required) {
				$this->required($label, $value);
			}

			if ($element->isPattern()) {
				$this->pattern($label, $value, $element);
			}
		}
		return $this->errors;
	}

	protected function findclass($element)
	{
		$class = get_class($element);
		$lastSlash = strrpos($class, "\\");
		return strtolower(substr($class, 17 + 1));
	}

	protected function required($label, $value)
	{
		if (empty($value)) {
			$this->errors[] = "{$label} is a required field.";
			return false;
		}

		return true;
	}

	protected function number($label, $value, $element)
	{
		if (!is_numeric($value)) {
			$this->errors[] = "{$label} must be a number.";
			return false;
		}

		return true;
	}

	protected function range($label, $value, $element)
	{
		$min = $element->min;
		$max = $element->max;

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

	protected function url($label, $value, $element)
	{
		if (!filter_var($value, FILTER_VALIDATE_URL)) {
			$this->errors[] = "{$label} must be a valid URL.";
		}

		return true;
	}

	protected function email($label, $value, $element)
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