<?php

namespace HtmlForm\Elements;

class File extends Field
{
	/**
     * Creates a file input form element
     * @param  array $value 	The current value of the form element
     * @return string 			The HTML for the input
     */
	public function compile($value = "")
	{
		return "{$this->compiledLabel}<input type=\"file\" name=\"{$this->name}\" {$this->compiledAttr} value=\"{$value}\" />";
	}
}