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


	public function __construct($ledgend = null, $attr = array())
	{
		$this->ledgend = $ledgend;
		$textManipulator = new Utility\TextManipulator();
		$this->compiledAttr = $textManipulator->arrayToTagAttributes($attr);
	}

	
}