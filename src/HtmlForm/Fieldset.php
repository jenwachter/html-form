<?php

namespace HtmlForm;

class Fieldset extends Abstracts\Addable
{
	/**
	 * Stores the value of
	 * the <ledgend> element
	 * @var string
	 */
	protected $ledgend;

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


	public function __construct($ledgend = null, $attr = array())
	{
		$this->ledgend = $ledgend;
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
		return "<fieldset><legend>{$this->ledgend}</legend>";
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