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

				// validate this addable (fieldset)
				$moreErrors = $this->validate($element);

			} else {

				$class = $this->findclass($element);

				if ($class == "honeypot") {
					$value = $element->getRawValue();
					$this->honeypot($value);
					continue;
				}

				// validate this element
				$elementErrors = $element->validate();

				// add new errors to the list
				$this->errors = array_merge($this->errors, $elementErrors);

			}

		}

		return empty($this->errors);
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
	 * Validates a honeypot form attribute. If there is an
	 * error, it is not added to the regular errors array,
	 * but is added to the $honeypotError property. If the
	 * form failed the honeypot test, you can catch this and
	 * make the bot think you submitted the form, but
	 * on the backend, just ignore it.
	 *
	 * @param  string $value   Current value of form field
	 * @return boolean TRUE if passed validation; FALSE if failed validation
	 */
	public function honeypot($value)
	{
		if (!is_null($value)) {
			$this->honeypotError = true;
		}
	}
}
