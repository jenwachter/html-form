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

	/**
	 * Runs through the validation required by
	 * each form element.
	 * 
	 * @return array Found errors
	 */
	public function validate()
	{
		foreach ($this->elements as $element) {

			$label = $element->label;
			$value = $element->getPostValue();
			$class = $this->findclass($element);

			// Runs validation assigned to this class
			if (method_exists($this, $class)) {
				$this->$class($label, $value, $element);
			}
			
			if ($element->required) {
				$this->required($label, $value, $element);
			}

			if ($element->isPattern()) {
				$this->pattern($label, $value, $element);
			}
		}
		return $this->errors;
	}

	/**
	 * Finds the class of the given form element
	 * 
	 * @param  object $element Form element object
	 * @return string Class name
	 */
	protected function findclass($element)
	{
		$class = get_class($element);
		$lastSlash = strrpos($class, "\\");
		return strtolower(substr($class, 17 + 1));
	}

	/**
	 * Validates a required form element.
	 * 
	 * @param  string $label   Form element label
	 * @param  string $value   Current value of form field
	 * @param  string $element Form element object
	 * @return boolean TRUE if passed validation; FALSE if failed validation
	 */
	protected function required($label, $value, $element)
	{
		if (empty($value)) {
			$this->errors[] = "{$label} is a required field.";
			return false;
		}

		return true;
	}

	/**
	 * Validates a number form element.
	 * 
	 * @param  string $label   Form element label
	 * @param  string $value   Current value of form field
	 * @param  string $element Form element object
	 * @return boolean TRUE if passed validation; FALSE if failed validation
	 */
	protected function number($label, $value, $element)
	{
		if (!is_numeric($value)) {
			$this->errors[] = "{$label} must be a number.";
			return false;
		}

		return true;
	}

	/**
	 * Validates a range form element.
	 * 
	 * @param  string $label   Form element label
	 * @param  string $value   Current value of form field
	 * @param  string $element Form element object
	 * @return boolean TRUE if passed validation; FALSE if failed validation
	 */
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

	/**
	 * Validates a URL form element.
	 * 
	 * @param  string $label   Form element label
	 * @param  string $value   Current value of form field
	 * @param  string $element Form element object
	 * @return boolean TRUE if passed validation; FALSE if failed validation
	 */
	protected function url($label, $value, $element)
	{
		if (!filter_var($value, FILTER_VALIDATE_URL)) {
			$this->errors[] = "{$label} must be a valid URL.";
		}

		return true;
	}

	/**
	 * Validates an email form element.
	 * 
	 * @param  string $label   Form element label
	 * @param  string $value   Current value of form field
	 * @param  string $element Form element object
	 * @return boolean TRUE if passed validation; FALSE if failed validation
	 */
	protected function email($label, $value, $element)
	{
		if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
			$this->errors[] = "{$label} must be a valid email address.";
		}

		return true;
	}

	/**
	 * Validates a form element with a pattern attribute.
	 * 
	 * @param  string $label   Form element label
	 * @param  string $value   Current value of form field
	 * @param  string $element Form element object
	 * @return boolean TRUE if passed validation; FALSE if failed validation
	 */
	protected function pattern($label, $value, $element)
	{
		$pattern = trim($element->attr["pattern"], "/");

		if (!preg_match("/{$pattern}/", $value)) {
			$this->errors[] = "{$label} must be match the specificed pattern.";
			return false;
		}

		return true;
	}
}