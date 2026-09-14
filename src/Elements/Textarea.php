<?php

namespace HtmlForm\Elements;

class Textarea extends Parents\Field
{
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

		$html .= "<textarea id=\"{$this->name}_id\" name=\"{$this->name}\" {$this->compiledAttr}>{$value}</textarea>";

		return $html;
	}
}
