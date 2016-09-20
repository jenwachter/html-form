<?php

namespace HtmlForm\Elements;

class Date extends Parents\Textbox
{
	/**
	 * Value of the "type" attribute of this form element
	 * @var string
	 */
	protected $type = "date";

	/**
	 * Regex acquired from: http://html5pattern.com/Dates
	 */
	public function validateType($value)
	{
		if (!preg_match("/(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))/", $value)) {
			$this->errors[] = "\"{$this->label}\" must be a valid date.";
			return false;
		}

		return true;
	}
}
