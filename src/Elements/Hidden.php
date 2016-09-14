<?php

namespace HtmlForm\Elements;

class Hidden extends Parents\Textbox
{
	/**
	 * Value of the "type" attribute of this form element
	 * @var string
	 */
	protected $type = "hidden";

	/**
	 * Builds the HTML of the form field.
	 *
	 * @param  string $value Value of the form field
	 * @return null
	 */
	public function compile($value = "")
	{
		$html = "<input type=\"{$this->type}\" name=\"{$this->name}\" {$this->compiledAttr} value=\"{$value}\" />";

		if (!empty($this->help)) {
			$html .= "<div class='help'>{$this->help}</div>";
		}
		
		return $html;
	}
}
