<?php

namespace HtmlForm\Elements\Parents;

abstract class Textbox extends Field
{
	/**
	 * Value of the "type" attribute of this form element
	 * @var string
	 */
	protected $type = "text";

	/**
	 * Builds the HTML of the form field.
	 *
	 * @param  string $value Value of the form field
	 * @return null
	 */
	public function compile($value = "")
	{
		$html = $this->compiledLabel;

		if (!empty($this->help)) {
			$html .= "<div class='help'>{$this->help}</div>";
		}

		$html .= "<input id=\"{$this->name}_id\" type=\"{$this->type}\" name=\"{$this->name}\" {$this->compiledAttr} value=\"{$value}\" />";

		return $html;
	}
}
