<?php

namespace HtmlForm\Elements\Parents;

class Option extends Field
{
	protected $options = array();

	public function __construct($name, $label, $options, $args = array())
	{
		parent::__construct($name, $label, $args);
		$this->options = $options;
	}

	/**
     * Checks an array to see if it is associative
     * @param  array  $a Array to check
     * @return boolean
     */
	protected static function hasOptionValue($a)
	{
		return (bool) count(array_filter(array_keys($a), "is_string"));
	}

	public function compile($value = "")
	{
		$html = "{$this->compiledLabel}";
		
		$hasOptionValue = $this->hasOptionValue($this->options);
		
		foreach ($this->options as $k => $v) {
			
			$html .= "<input type=\"{$this->type}\" {$this->compiledAttr}";
			$html .= "name=\"" . $this->name . "[]\" ";
			
			// handle options in an associative array differently than ones in a numeric array
			if ($hasOptionValue) {
				$html .= "value=\"{$k}\" ";
				if ($k == $value || (is_array($value) && in_array($k, $value))) {
					$html .= " checked=\"checked\"";
				}
			
			} else {
				$html .= "value=\"{$v}\" ";
				if ($v == $value || (is_array($value) && in_array($v, $value))) {
					$html .= " checked=\"checked\"";
				}
			}

			$html .= " /> {$v}";
		}
		
		return $html;
	}
}