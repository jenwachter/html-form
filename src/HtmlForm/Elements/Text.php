<?php

namespace HtmlForm\Elements;

class Text extends Field
{
	protected $password = false;

	/**
     * Creates an input form element
     * @param  array $value 	The current value of the form element
     * @return string 			The HTML for the input
     */
	public function compile($value = "")
	{
		$type = $this->password ? "password" : "text";
		return "{$this->compiledLabel}<input type=\"{$type}\" name=\"{$this->name}\" {$this->compiledAttr} value=\"{$value}\" />";
	}
}