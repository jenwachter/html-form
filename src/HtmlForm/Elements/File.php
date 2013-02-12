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
		return "{$this->label}<input type=\"file\" name=\"{$this->name}\" {$this->attr} value=\"{$value}\" />";
	}
}