<?php

namespace HtmlForm\Elements\Parents;

abstract class Field
{
	/**
	 * HTML to appear before an element
	 * @var string
	 */
	public $beforeElement = null;

	/**
	 * HTML to appear after an element
	 * @var string
	 */
	public $afterElement = null;

	/**
	 * Symbol that denotes this field
	 * is required.
	 * @var string
	 */
	protected $requiredSymbol = "<span class='required'>*</span>";

	/**
	 * Is the field required?
	 * @var boolean
	 */
	protected $required = false;

	/**
	 * Help text
	 * @var string
	 */
	protected $help = false;

	/**
	 * Value of the "name" attribute
	 * of the form element
	 * @var string
	 */
	protected $name;

	/**
	 * Readable label attached
	 * to the form element.
	 * @var string
	 */
	protected $label;

	/**
	 * Associative array of additional
	 * options to pass to the element.
	 * "attribute" => "value"
	 * @var array
	 */
	public $attr = array();

	/**
	 * Default value of the form field
	 * @var string
	 */
	protected $defaultValue = "";

	/**
	 * Stores the compiled HTML
	 * label element
	 * @var string
	 */
	protected $compiledLabel;

	/**
	 * Stores the compiled additional
	 * attributes string.
	 * @var [string
	 */
	protected $compiledAttr;

	/**
	 * Errors found on this fild
	 * @var array
	 */
	public $errors = array();

	/**
	 * Assigns variables to object, compiles
	 * label and attributes.
	 *
	 * @param string $name   Value of the "name" attribute of the form element
	 * @param string $label  Readable label attached to the form element.
	 * @param array  $args   Associative array of additional options to pass
	 *                       to the element. "attribute" => "value"
	 */
	public function __construct($name, $label, $args = array())
	{
		$this->name = $name;
		$this->label = $label;

		$textManipulator = new \HtmlForm\Utility\TextManipulator();
		$this->attr = !empty($args["attr"]) ? $args["attr"] : array();

		$this->compiledAttr = !empty($args["attr"]) ? $textManipulator->arrayToTagAttributes($args["attr"]) : null;

		$this->extractArgs($args);
		$this->compileLabel();
	}

	/**
	 * Builds the HTML of the form field.
	 *
	 * @param  string $value Value of the form field
	 * @return null
	 */
	public abstract function compile($value = "");

	/**
	 * Loops through a given array and it the key
	 * exists as a property on this object, it is
	 * assigned.
	 *
	 * @param  array $args Associative array
	 * @return self
	 */
	public function extractArgs($args)
	{
		foreach ($args as $k => $v) {
			if (property_exists($this, $k)) {
				$this->$k = $v;
			} else {
				throw new \InvalidArgumentException("{$k} is not a valid option.");
			}
		}
	}

	/**
     * Builds the HTML for the label of a form element
     * @return self
     */
	public function compileLabel()
	{
		$required = $this->required ? $this->requiredSymbol . " " : "";
		$this->compiledLabel = "<label for=\"{$this->name}\">{$required}{$this->label}</label>";

		return $this;
	}

	/**
	 * Get the raw $_POST value of a field
	 * @return string
	 */
	public function getRawValue()
	{
		$name = $this->name;
		return !empty($_POST[$name]) ? $_POST[$name] : null;
	}

	/**
	 * Get the value to display in the form field.
	 * Either the value in the session, post data,
	 * the default value, or nothing.
	 * @param  string Form ID
	 * @return [type] [description]
	 */
	public function getDisplayValue($formid = null)
	{
		if ($formid && isset($_SESSION[$formid][$this->name])) {
			$value = $_SESSION[$formid][$this->name];
		} else if (isset($_POST[$this->name])) {
			$value = $_POST[$this->name];
		} else {
			$value = $this->defaultValue;
		}

		return $this->cleanValue($value);
	}

	/**
	 * Clean a value up for repopulation in a form field
	 * @param  mixed $value String or array
	 * @return mixed
	 */
	protected function cleanValue($value)
	{
		if (is_array($value)) {
			return array_map(function ($v) {
				return $this->cleanValue($v);
			}, $value);
		} else {
			return stripslashes($value);
		}
	}

	/**
	 * Validate a field
	 * @return boolean TRUE is valid; FALSE if invalid
	 */
	public function validate()
	{
		$this->errors = array();
		$value = $this->getRawValue();

		if ($this->required) {

			$passed = $this->validateRequired($value);

			// don't do anymore validation until it passes the required validation
			if (!$passed) return $this->errors;

			// validate by field type
			$this->validateType($value);

			// validate by pattern, if defined
			$this->validatePattern($value);

			// hook for users?

		}

		return $this->errors;
	}

	/**
	 * Validates a required form element.
	 *
	 * @param  string $value   Current value of form field
	 * @return boolean
	 */
	public function validateRequired($value)
	{
		if (empty($value)) {
			$this->errors[] = "\"{$this->label}\" is a required field.";
			return false;
		}

		return true;
	}

	/**
	 * Validation function based on field type
	 * Can be overwritten by user if needed
	 * @param  string $value   Current value of form field
	 * @return boolean
	 */
	public function validateType($value)
	{
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
	public function validatePattern($value)
	{
		if (!isset($this->attr["pattern"])) return true;

		$pattern = trim($this->attr["pattern"], "/");

		if (!preg_match("/{$pattern}/", $value)) {
			$this->errors[] = "\"{$this->label}\" must match the specified pattern.";
			return false;
		}

		return true;
	}

	/**
	 * Enables retrieval of protected variables.
	 * @param  string $var Variable to get
	 * @return mixed The requested variable
	 */
	public function __get($var)
	{
		return $this->$var;
	}
}
