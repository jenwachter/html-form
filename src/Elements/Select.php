<?php

namespace HtmlForm\Elements;

class Select extends Parents\Option
{
  protected $multiple = false;

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

    $name = $this->multiple ? "{$this->name}[]" : $this->name;
    $attr = $this->multiple ? "{$this->compiledAttr} multiple=\"true\"" : $this->compiledAttr;

		$html .= "<select id=\"{$this->name}_id\" name=\"{$name}\" {$attr}>";

    foreach ($this->options as $k => $v) {
      $html .= "<option value=\"{$k}\"";
      if ($this->isSelected($value, $k, $v)) {
        $html .= " selected=\"selected\"";
      }
      $html .= ">{$v}</option>";
    }

		$html .= "</select>";

		return $html;
	}

  protected function isSelected($postValue, $optionKey, $optionValue): bool
  {
    if (empty($postValue)) {
      return false;
    }

    $postValue = (array) $postValue;

    if ($this->hasOptionValue($this->options) || $this->useNumericValue) {
      // handle options in an associative array differently than ones in a numeric array
      return in_array($optionKey, $postValue);
    } else {
      return in_array($optionValue, $postValue);
    }
  }
}
