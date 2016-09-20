<?php

namespace HtmlForm\Elements;

class Url extends Parents\Textbox
{
	/**
	 * Value of the "type" attribute of this form element
	 * @var string
	 */
	protected $type = "url";

	public function validateType($value)
	{
		if (!filter_var($value, FILTER_VALIDATE_URL)) {
			$this->errors[] = "\"{$this->label}\" must be a valid URL.";
			return false;
		}

		return true;
	}
}
