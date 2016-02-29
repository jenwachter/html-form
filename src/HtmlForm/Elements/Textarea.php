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
		$html = "{$this->compiledLabel}<textarea name=\"{$this->name}\" {$this->compiledAttr}>{$value}</textarea>";
		
		if (!empty($this->help)) {
			$html .= "<div class='help'>{$this->help}</div>";
		}

		return $html;
	}
}
