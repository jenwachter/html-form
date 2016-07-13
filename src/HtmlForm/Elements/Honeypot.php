<?php

namespace HtmlForm\Elements;

class Honeypot extends Parents\Textbox
{
	/**
	 * Builds the HTML of the form field.
	 *
	 * @param  string $value Value of the form field
	 * @return null
	 */
	public function compile($value = "")
	{
		return "<div class=\"honeypot\" style=\"display: none;\"><input type=\"{$this->type}\" name=\"{$this->name}\" {$this->compiledAttr} value=\"{$value}\" /></div>";
	}
}
