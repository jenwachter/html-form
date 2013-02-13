<?php

namespace HtmlForm\Elements;

class Button extends Field
{
	protected $type = "submit";

	public function __construct($name, $args = array())
	{
		$this->name = $name;

		foreach ($args as $k => $v) {
			if (property_exists($this, $k)) {
				$this->$k = $v;
			}
		}

		$this->compiledAttr = $this->compileAttributes();
	}

	/**
     * Creates a button form element
     * @param  array $value 	The current value of the form element
     * @return string 			The HTML for the input
     */
	public function compile($value = "")
	{
		return "<input type=\"{$this->type}\" name=\"{$this->name}\" {$this->compiledAttr} value=\"{$this->defaultValue}\" />";
	}
}