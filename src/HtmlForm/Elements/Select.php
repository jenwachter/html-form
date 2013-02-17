<?php

namespace HtmlForm\Elements;

class Select extends Parents\Option
{
	/**
	 * Creates a select box form element. Override parent
	 * compile() method.
	 *
     * @param array $field an array that defines the form element
     * @return string the select box
     */
	public function compile($value = "")
	{
		$hasOptionValue = $this->hasOptionValue($this->options);
		
		$html = "{$this->compiledLabel}";
		$html .= "<select name=\"{$this->name}\" {$this->compiledAttr}>";
		
		
		// handle options in an associative array differently than ones in a numeric array
		if ($hasOptionValue) {
			
			foreach ($this->options as $k => $v) {
				$html .= "<option value=\"{$k}\"";
				if ($value == $k) {
					$html .= " selected=\"selected\"";
				}
				$html .= ">{$v}</option>";
			}
		
		} else {
		
			foreach ($this->options as $k => $v) {
				$html .= "<option value=\"{$v}\"";
				if ( $value == $v) {
					$html .= " selected=\"selected\"";
				}
				$html .= ">{$v}</option>";
			}
		}
		
		$html .= "</select>";
		return $html;
	}
}