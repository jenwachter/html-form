<?php

namespace HtmlForm\Elements;

class Range extends Parents\Textbox
{
	protected $type = "number";
	public $min;
	public $max;

	public function __construct($name, $label, $min, $max, $args = array())
	{
		parent::__construct($name, $label, $args);
		$this->min = $min;
		$this->max = $max;
	}
}