<?php

namespace HtmlForm;

class Form extends Abstracts\Addable
{
	/**
	 * Form configuration
	 * @var array
	 */
	public $config = array();

	/**
	 * Stores the compiled additional
	 * attributes string.
	 * @var string
	 */
	protected $compiledAttr;

	/**
	 * Validator object
	 * @var object
	 */
	public $validator;

	/**
	 * Form elements contained within this object
	 * @var array
	 */
	public $elements = array();

	/**
	 * Sets up the form
	 * @param array $config Associaitve array of configuration overrides
	 */
	public function __construct($config = array())
	{
		$this->setConfig($config);
		$this->validator = new \HtmlForm\Utility\Validator();
		$this->compiledAttr = Utility\TextManipulator::arrayToTagAttributes($this->config["attr"]);
	}

	/**
	 * Merge passed config with default config.
	 * @param array $config Form configuration
	 */
	public function setConfig($config)
	{
		$action = isset($_SERVER["QUERY_STRING"]) ? $_SERVER["PHP_SELF"] . "?" . $_SERVER["QUERY_STRING"] : $_SERVER["PHP_SELF"];

		$defaults = array(
			"action" => $action,
			"id" => "hfc",
			"repopulate" => true,
			"attr" => array(),
			"beforeElement" => "",
			"afterElement" => ""
		);

		$this->config = array_merge($defaults, $config);
	}

	/**
	 * Fetches the HTML designated to go before
	 * a specific form element.
	 *
	 * @param  object $element Form element object
	 * @return string The HTML
	 */
	protected function beforeElement($element)
	{
		return !is_null($element->beforeElement) ? $element->beforeElement : $this->config["beforeElement"];
	}

	/**
	 * Fetches the HTML designated to go after
	 * a specific form element.
	 *
	 * @param  object $element Form element object
	 * @return string The HTML
	 */
	protected function afterElement($element)
	{
		return !is_null($element->afterElement) ? $element->afterElement : $this->config["afterElement"];
	}

	public function addHoneypot($args = array())
	{
		$element = new \HtmlForm\Elements\Honeypot(sha1($this->config["id"]), "", $args);
		$this->elements[] = $element;

		return $this;
	}

	public function addFieldset($label = null, $args = array())
	{
		$fieldset = new \HtmlForm\Fieldset($label, $args);
		$this->elements[] = $fieldset;

		return $fieldset;
	}

    /**
     * Checks the validity of the form and enables
     * form field repopulating
     *
     * @return boolean TRUE if form is valid; FALSE if there are errors
     */
	public function isValid()
	{
		$this->saveToSession();
		return $this->validator->validate($this);
	}

	public function passedHoneypot()
	{
		return !$this->validator->honeypotError;
	}

	/**
	 * Sets an error message manually. Useful if you need
	 * to push an error message from your own logic.
	 *
	 * @param string $message Error message text
	 */
	public function setErrorMessage($message)
	{
		$this->validator->pushError($message);
	}

	/**
	 * Saves form data to the session.
	 *
	 * @return null
	 */
	protected function saveToSession()
	{
		if ($this->config["repopulate"]) {
			foreach ($_POST as $k => $v) {
				$_SESSION[$this->config["id"]][$k] = $v;
			}
		}
	}

	/**
	 * Outputs the HTML form
	 *
     * @return null
     */
	public function display()
	{
		echo $this->render();
	}

	/**
	 * Creates the form HTML
	 * @return string The form HTML
	 */
	public function render()
	{
		$html = $this->validator->renderErrors();
		$html .= $this->renderElements($this);

		return $html;
	}

	/**
	 * Creates the opening <form> tag
	 * @return string
	 */
	protected function getOpeningTag()
	{
		return "<form method=\"post\" action=\"{$this->config["action"]}\" id=\"{$this->config["id"]}\" {$this->compiledAttr}>";
	}

	/**
	 * Creates the closing </form> tag
	 * @return string
	 */
	protected function getClosingTag()
	{
		return "</form>";
	}

	/**
	 * Compiles HTML for each form element
	 * @param  object $addable Object that extends from \HtmlForm\Abstracts\Addable
	 * @return string HTML of form elements
	 */
	protected function renderElements($addable)
	{
		$html = $addable->getOpeningTag();

		foreach ($addable->elements as $element) {

			$classes = class_parents($element);

			if (in_array("HtmlForm\Abstracts\Addable", $classes)) {
				$html .= $this->renderElements($element);
			} else if (in_array("HtmlForm\Elements\Parents\Html", $classes)) {
				$html .= $element->compile();
			} else {
				$value = $element->getDisplayValue($this->config["id"]);
				$html .= $this->beforeElement($element);
				$html .= $element->compile($value);
				$html .= $this->afterElement($element);
			}
		}

		$html .= $addable->getClosingTag();

		return $html;
	}
}
