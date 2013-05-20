<?php

namespace HtmlForm;

class Fieldset extends Abstracts\Addable
{
	/**
	 * Stores the value of
	 * the <legend> element
	 * @var string
	 */
	protected $legend;

	/**
	 * Stores the compiled additional
	 * attributes string.
	 * @var [string
	 */
	protected $compiledAttr;

	/**
	 * Form elements contained within this object
	 * @var array
	 */
	public $elements = array();


	public function __construct($legend = null, $attr = array())
	{
		$this->legend = $legend;
		$textManipulator = new Utility\TextManipulator();
		$this->compiledAttr = $textManipulator->arrayToTagAttributes($attr);
	}

	/**
	 * Creates the opening <fieldset> tag
	 * along with the <legend> tag
	 * @return string
	 */
	public function getOpeningTag()
	{
		return "<fieldset><legend>{$this->legend}</legend>";
	}

	/**
	 * Creates the closing <fieldset> tag
	 * @return string
	 */
	public function getClosingTag()
	{
		return "</fieldset>";
	}
}