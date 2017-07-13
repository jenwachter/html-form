<?php

namespace HtmlForm\Elements;

class Select extends Parents\Option
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

		$hasOptionValue = $this->hasOptionValue($this->options);

		$html .= "<select name=\"{$this->name}\" {$this->compiledAttr}>";

		// handle options in an associative array differently than ones in a numeric array
		if ($hasOptionValue || $this->useNumericValue) {

			foreach ($this->options as $k => $v) {
				$html .= "<option value=\"{$k}\"";
				if ($value === $k || (is_numeric($value) && (int) $value === $k)) {
					$html .= " selected=\"selected\"";
				}
				$html .= ">{$v}</option>";
			}

		} else {

			foreach ($this->options as $k => $v) {
				$html .= "<option value=\"{$v}\"";
				if ( $value === $v) {
					$html .= " selected=\"selected\"";
				}
				$html .= ">{$v}</option>";
			}
		}

		$html .= "</select>";

		return $html;
	}
}
