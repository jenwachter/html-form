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

    $assocOptions = !array_is_list($this->options);

    foreach ($this->options as $k => $v) {
      $html .= "<option ";

      // handle options in an associative array differently than ones in a numeric array
      if ($assocOptions || $this->useNumericValue) {
        $html .= "value=\"{$k}\" ";
        if ($k === $value || (is_array($value) && in_array($k, $value))) {
          $html .= "selected=\"selected\"";
        }

      } else {
        $html .= "value=\"{$v}\" ";
        if ($v === $value || (is_array($value) && in_array($v, $value))) {
          $html .= "selected=\"selected\"";
        }
      }
      
      $html .= ">{$v}</option>";
    }

		$html .= "</select>";

		return $html;
	}
}
