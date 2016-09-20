<?php

namespace HtmlForm\Elements;

class Range extends Parents\Textbox
{
	/**
	 * Value of the "type" attribute of this form element
	 * @var string
	 */
	protected $type = "number";

	/**
	 * Minimum value this form field can have to
	 * pass validation
	 * @var integer
	 */
	public $min;

	/**
	 * Maximum value this form field can have to
	 * pass validation
	 * @var integer
	 */
	public $max;

	/**
	 * Runs the parent constructor and also saves the minimum
	 * and maximum values acceptable to this object.
	 *
	 * @param string $name  	Value of the "name" attribute of the form element
	 * @param string $label 	Readable label attached to the form element.
	 * @param string $min 		Minimum value this form field can have to pass validation
	 * @param string $max 		Maximum value this form field can have to pass validation
	 * @param array  $args  	Associative array of additional options to pass
	 *                       	to the element. "attribute" => "value"
	 */
	public function __construct($name, $label, $min, $max, $args = array())
	{
		$args["attr"]["min"] = $min;
		$args["attr"]["max"] = $max;
		parent::__construct($name, $label, $args);

		$this->min = $min;
		$this->max = $max;
	}

	public function validateType($value)
	{
		if (!$this->number($label, $value, $element)) {
			return false;
		}

		if ($value < $this->min || $value > $this->max) {
			$this->errors[] = "\"{$this->label}\" must be a number between {$this->min} and {$this->max}.";
			return false;
		}

		return true;
	}
}
