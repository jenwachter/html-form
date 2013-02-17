<?php

namespace HtmlForm\Elements\Parents;

class Textbox extends Field
{
	protected $type = "text";

	/**
     * Creates an input form element
     * @param  array $value 	The current value of the form element
     * @return string 			The HTML for the input
     */
	public function compile($value = "")
	{
		return "{$this->compiledLabel}<input type=\"{$this->type}\" name=\"{$this->name}\" {$this->compiledAttr} value=\"{$value}\" />";
	}
}