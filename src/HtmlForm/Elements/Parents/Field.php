<?php

namespace HtmlForm\Elements\Parents;

abstract class Field implements \HtmlForm\Interfaces\Field
{
	/**
	 * HTML to appear before an element
	 * @var string
	 */
	protected $beforeElement = null;

	/**
	 * HTML to appear after an element
	 * @var string
	 */
	protected $afterElement = null;


	/**
	 * Symbol that denotes this field
	 * is required.
	 * @var string
	 */
	protected $requiredSymbol = "*";
	
	/**
	 * Is the field required?
	 * @var boolean
	 */
	protected $required = false;

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
	protected $attr = array();
	
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

	public function __construct($name, $label, $args = array())
	{
		$this->name = $name;
		$this->label = $label;

		$this->extractArgs($args);

		$this->compiledLabel = $this->compileLabel();
		$this->compiledAttr = $this->compileAttributes();
	}

	public function extractArgs($args)
	{
		foreach ($args as $k => $v) {
			if (property_exists($this, $k)) {
				$this->$k = $v;
			}
		}
	}

	public abstract function compile($field);

	/**
     * Gets the HTML for the label of a form element
     * @param  array $field An array of variables that define the form element
     * @return string 		The form element"s HTML label
     */
	public function compileLabel()
	{	
		$required = !empty($this->required) ? $this->requiredSymbol : "";
		return "<label for=\"{$this->name}\">{$required}{$this->label}</label>";
	}
	
    /**
     * Fetches the HTML attributes of a form element
     * @return string 			The form element"s attributes
     */
	public function compileAttributes()
	{
		$attributes = "";
		foreach ($this->attr as $k => $v) {
		    $attributes .= "{$k}=\"{$v}\" ";
		}
		return $attributes;
	}

	public function getPostValue()
	{
		$name = $this->name;
		return !empty($_POST[$name]) ? $_POST[$name] : null;
	}

	public function isPattern()
	{
		$attr = array_keys($this->attr);
		return in_array("pattern", $attr);
	}

	public function __get($var)
	{
		return $this->$var;
	}
}