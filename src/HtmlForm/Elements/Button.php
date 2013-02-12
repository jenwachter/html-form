<?php

namespace HtmlForm\Elements;

class Button extends Field
{
	/**
     * Creates a button form element
     * @param  array $value 	The current value of the form element
     * @return string 			The HTML for the input
     */
	public function compile($value = "")
	{
		return "<input type=\"button\" name=\"{$this->name}\" {$this->attr} value=\"{$value}\" />";
	}
}