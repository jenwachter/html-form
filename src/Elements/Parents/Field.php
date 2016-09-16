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
	 * Determines whether this form field has a
	 * "pattern" attribute.
	 * @return boolean
	 */
	public function isPattern()
	{
		$attr = array_keys($this->attr);
		return in_array("pattern", $attr);
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
