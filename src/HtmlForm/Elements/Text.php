<?php

namespace HtmlForm\Elements;

class Text extends Field
{
	/**
     * Creates an input form element
     * @param  array $value 	The current value of the form element
     * @return string 			The HTML for the input
     */
	public function compile($value = "")
	{
		return "{$this->label}<input type=\"text\" name=\"{$this->name}\" {$this->attr} value=\"{$value}\" />";
	}
}