<?php

namespace HtmlForm\Utility;

class Validator
{
	/**
	 * Found errors
	 * @var array
	 */
	public $errors = array();

	/**
	 * Honeypot error
	 * @var boolean
	 */
	public $honeypotError = false;

	public function __construct()
	{

	}

	/**
	 * Runs through the validation required by
	 * each form element.
	 * @param  object $addable Object that extends from \HtmlForm\Abstracts\Addable
	 * @return array Found errors
	 */
	public function validate($addable)
	{
		foreach ($addable->elements as $element) {

			$classes = class_parents($element);

			// no validation needed
			if (in_array("HtmlForm\Elements\Parents\Html", $classes)) {
				continue;
			}

			if (in_array("HtmlForm\Abstracts\Addable", $classes)) {
				$this->validate($element);
			} else {
				$label = $element->label;
				$value = $element->getRawValue();
				$class = $this->findclass($element);

				if ($class == "honeypot") {
					$this->honeypot($label, $value, $element);
				}

				if ($element->required && $this->required($label, $value, $element)) {

					if (method_exists($this, $class)) {
						$this->$class($label, $value, $element);
					}
					if ($element->isPattern()) {
						$this->pattern($label, $value, $element);
					}
				}
			}

		}
		return $this->errors;
	}

	public function renderErrors()
	{
		if (empty($this->errors)) {
			return;
		}

		$html = "";

		$count = count($this->errors);
		$message = $count > 1 ? "The following {$count} errors were found:" : "The following error was found:";

		$html .= "<div class=\"alert alert-error\">";
		$html .= "<p class=\"alert-heading\">{$message}</p>";
		$html .= "<ul>";

		foreach ($this->errors as $k => $v) {
			$html .= "<li>{$v}</li>";
		}

		$html .= "</ul></div>";
		return $html;
	}

	public function pushError($error)
	{
		$this->errors[] = $error;
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
		return strtolower(substr($class, $lastSlash + 1));
	}

	/**
	 * Validates a required form element.
	 *
	 * @param  string $label   Form element label
	 * @param  string $value   Current value of form field
	 * @param  string $element Form element object
	 * @return boolean TRUE if passed validation; FALSE if failed validation
	 */
	public function required($label, $value, $element)
	{
		if (empty($value)) {
			$this->pushError("\"{$label}\" is a required field.");
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
	public function number($label, $value, $element)
	{
		if (!is_numeric($value)) {
			$this->pushError("\"{$label}\" must be a number.");
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
	public function range($label, $value, $element)
	{
		$min = $element->min;
		$max = $element->max;

		if (!$this->number($label, $value, $element)) {
			return false;
		}

		if ($value < $min || $value > $max) {
			$this->pushError("\"{$label}\" must be a number between {$min} and {$max}.");
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
	public function url($label, $value, $element)
	{
		if (!filter_var($value, FILTER_VALIDATE_URL)) {
			$this->pushError("\"{$label}\" must be a valid URL.");
			return false;
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
	public function email($label, $value, $element)
	{
		if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
			$this->pushError("\"{$label}\" must be a valid email address.");
			return false;
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
	public function pattern($label, $value, $element)
	{
		$pattern = trim($element->attr["pattern"], "/");

		if (!preg_match("/{$pattern}/", $value)) {
			$this->pushError("\"{$label}\" must be match the specificed pattern.");
			return false;
		}

		return true;
	}

	/**
	 * Validates a honeypot form attribute. If there is an
	 * error, it is not added to the regular errors array,
	 * but is added to the $honeypotError property. If the
	 * form failed the honeypot test, you can catch this and
	 * make the bot think you submitted the form, but
	 * on the backend, just ignore it.
	 *
	 * @param  string $label   Form element label
	 * @param  string $value   Current value of form field
	 * @param  string $element Form element object
	 * @return boolean TRUE if passed validation; FALSE if failed validation
	 */
	public function honeypot($label, $value, $element)
	{
		if (!is_null($value)) {
			$this->honeypotError = true;
			return false;
		}

		return true;
	}
}
