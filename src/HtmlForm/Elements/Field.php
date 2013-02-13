<?php

namespace HtmlForm\Elements;

abstract class Field implements \HtmlForm\Interfaces\Field
{
	public $requiredSymbol = "*";

	public $beforeElement = null;

	public $afterElement = null;

	protected $name;
	
	protected $label;

	protected $args = array();

	protected $compiledLabel;
	
	protected $defaultValue = "";
	
	protected $required = false;
	
	protected $attr = array();

	protected $compiledAttr;

	public function __construct($name, $label, $args = array())
	{
		$this->name = $name;
		$this->label = $label;
		$this->args = $args;

		$this->extractArts($args);

		$this->compiledLabel = $this->compileLabel();
		$this->compiledAttr = $this->compileAttributes();
	}

	public function extractArts($args)
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

	public function getLabel()
	{
		return $this->label;
	}
}