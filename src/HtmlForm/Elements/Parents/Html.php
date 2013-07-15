<?php

namespace HtmlForm\Elements\Parents;

abstract class Html
{
	/**
	 * HTML to appear before an element
	 * @var string
	 */
	public $beforeElement = null;

	/**
	 * HTML to appear after an element
	 * @var string
	 */
	public $afterElement = null;
	
	public $name;
	protected $html;

	public function __construct($name, $html)
	{
		$this->name = $name;
		$this->html = $html;
	}

	public function compile()
	{
		return $this->html;
	}
}