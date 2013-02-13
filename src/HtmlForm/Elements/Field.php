<?php

namespace HtmlForm\Elements;

abstract class Field implements \HtmlForm\Interfaces\Field
{
	public $requiredSymbol = "*";

	public $beforeElement = null;

	public $afterElement = null;

	protected $name;
	
	protected $label;

	protected $compiledLabel;
	
	protected $defaultValue = "";
	
	protected $required = false;
	
	protected $attr = array();

	protected $compiledAttr;
	
	protected $options = array();

	public function __construct($name, $label = null, $args = array())
	{
		$this->name = $name;
		$this->label = $label;

		foreach ($args as $k => $v) {
			if (property_exists($this, $k)) {
				$this->$k = $v;
			}
		}

		$this->compiledLabel = $this->compileLabel();
		$this->compiledAttr = $this->compileAttributes();
	}

	public abstract function compile($field);

	/**
     * Gets the HTML for the label of a form element
     * @param  array $field An array of variables that define the form element
     * @return string 		The form element"s HTML label
     */
	public function compileLabel()
	{	
		if (is_null($this->label)) {
			return;
		}
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

	public function getName()
	{
		return $this->name;
	}

	public function getDefaultValue()
	{
		return $this->defaultValue;
	}

	public function isRequired()
	{
		return $this->required;
	}
}