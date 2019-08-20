<?php

namespace HtmlForm\Elements\Parents;

abstract class Option extends Field
{
	/**
	 * Array of options available to the use
	 * in the form element.
	 * @var array
	 */
	protected $options = array();

	/**
	 * By default, if an array of options is passed as
	 * a numeric array, the select box will render with
	 * the values passed as both the "value" attribute of
	 * <option> AND the text displayed to the user. This
	 * variable will override that functionality and
	 * display the numeric keys as the "value" attribute.
	 * @var boolean
	 */
	protected $useNumericValue = false;

	/**
	 * Runs the parent constructor and also saves the
	 * options to the obejct.
	 *
	 * @param string $name  	Value of the "name" attribute of the form element
	 * @param string $label 	Readable label attached to the form element.
	 * @param array  $options   Array of options available to the use in the form element.
	 * @param array  $args  	Associative array of additional options to pass
	 *                       	to the element. "attribute" => "value"
	 */
	public function __construct($name, $label, $options, $args = array())
	{
		parent::__construct($name, $label, $args);
		$this->options = $options;
	}

	/**
     * Checks an array to see given array is associative. This solution
     * was found on Stack Overflow: http://stackoverflow.com/a/4254008
     *
     * @param  array  $a Array to check
     * @return boolean
     */
	protected function hasOptionValue($a)
	{
		return (bool) count(array_filter(array_keys($a), "is_string"));
	}

	/**
	 * Builds the HTML of the form field.
	 *
	 * @param  string $value Value of the form field
	 * @return null
	 */
	public function compile($value = "")
	{
		$html = "<div class=\"label\">{$this->getLabelText()}</div>";

		if (!empty($this->help)) {
			$html .= "<div class='help'>{$this->help}</div>";
		}

		$html .= "<div class=\"elements\">";

		$hasOptionValue = $this->hasOptionValue($this->options);

		foreach ($this->options as $k => $v) {

			$html .= "<div class=\"element\"><label><input type=\"{$this->type}\" {$this->compiledAttr} ";
			$html .= "name=\"" . $this->name;

			if ($this->type == "checkbox") {
				$html .= "[]";
			}

			$html .= "\" ";

			// handle options in an associative array differently than ones in a numeric array
			if ($hasOptionValue || $this->useNumericValue) {
				$html .= "value=\"{$k}\" ";
				if ($k === $value || (is_array($value) && in_array($k, $value))) {
					$html .= "checked=\"checked\"";
				}

			} else {
				$html .= "value=\"{$v}\" ";
				if ($v === $value || (is_array($value) && in_array($v, $value))) {
					$html .= "checked=\"checked\"";
				}
			}

			$html .= " /> <span>{$v}</span></label></div>";
		}

		$html .= "</div>";

		return $html;
	}
}
