<?php

namespace HtmlForm\Elements;

class Button extends Parents\Field
{
	/**
	 * Value of the "type" attribute of this form element
	 * @var string
	 */
	protected $type = "submit";

	/**
	 * Builds the HTML of the form field.
	 * 
	 * @param  string $value Value of the form field
	 * @return null
	 */
	public function compile($value = "")
	{
		return "<input type=\"{$this->type}\" name=\"{$this->name}\" {$this->compiledAttr} value=\"{$this->label}\" />";
	}
}