<?php

namespace HtmlForm\Elements;

class Email extends Parents\Textbox
{
	/**
	 * Value of the "type" attribute of this form element
	 * @var string
	 */
	protected $type = "email";

	public function validateType($value)
	{
		if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
			$this->errors[] = "\"{$this->label}\" must be a valid email address.";
			return false;
		}

		return true;
	}
}
