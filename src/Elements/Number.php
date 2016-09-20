<?php

namespace HtmlForm\Elements;

class Number extends Parents\Textbox
{
	/**
	 * Value of the "type" attribute of this form element
	 * @var string
	 */
	protected $type = "number";

	public function validateType($value)
	{
		if (!is_numeric($value)) {
			$this->errors[] = "\"{$this->label}\" must be a number.";
			return false;
		}

		return true;
	}
}
