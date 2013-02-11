<?php

namespace HtmlForm\Fields;

class Textarea extends Field
{
	/**
	 * Creates a textarea form element
	 *
     * @param array $field an array that defines the form element
     * @return string the textarea
     */
	public function compile($field)
	{
		$html = "";
		$value = $this->getValue($field);
		
		$html .= "<textarea name=\"{$field["name"]}\" ";
		$html .= "{$this->compileAttributes($field)}>";
		$html .= "{$value}</textarea>";
		return $html;
	}
}