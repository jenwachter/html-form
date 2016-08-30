<?php

namespace HtmlForm;

class Form extends Abstracts\Addable
{
	/**
	 * Form configuration
	 * @var array
	 */
	protected $config = array();

	/**
	 * Stores the compiled additional
	 * attributes string.
	 * @var [string
	 */
	protected $compiledAttr;

	/**
	 * Validator object
	 * @var object
	 */
	protected $validator;

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
	 * Builds the "action" attribute, which defaults to
	 * the current page plus any query sting
	 *
	 * @return string Form action
	 */
	protected function buildAction()
	{
		return isset($_SERVER["QUERY_STRING"]) ? $_SERVER["PHP_SELF"] . "?" . $_SERVER["QUERY_STRING"] : $_SERVER["PHP_SELF"];
	}

	public function setConfig($config)
	{
		$defaults = array(
			"action" => $this->buildAction(),
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
		return $element->beforeElement ? $element->beforeElement : $this->config["beforeElement"];
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
		return $element->afterElement ? $element->afterElement : $this->config["afterElement"];
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

		if ($this->validator->validate($this)) {
			return false;
		} else {
			return true;
		}
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
     * Gets the current value attribute of a form element
     * @param  object $name 	Form element object
     * @return string 			The form element's current value
     */
	protected function getValue($element)
	{
		$name = $element->name;

		if (isset($_SESSION[$this->config["id"]][$name])) {
			return $this->cleanValue($_SESSION[$this->config["id"]][$name] );

		} else if (isset($_POST[$name])) {
			return $this->cleanValue($_POST[$name]);

		} else if (property_exists($element, "defaultValue")) {
			return $this->cleanValue($element->defaultValue);

		} else {
			return "";
		}
	}

	protected function cleanValue($value)
	{
		if (is_array($value)) {
			$a = array();
			foreach ($value as $v) {
				$a[] = stripslashes($v);
			}
			return $a;
		} else {
			return stripslashes($value);
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
		return "<form method=\"{$this->config["method"]}\" action=\"{$this->config["action"]}\" id=\"{$this->config["id"]}\" {$this->compiledAttr}>";
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
		if (!is_object($addable) || is_object($addable) && !in_array("HtmlForm\Abstracts\Addable", class_parents($addable))) {
			return;
		}

		$html = $addable->getOpeningTag();

		foreach ($addable->elements as $element) {

			$classes = class_parents($element);

			if (in_array("HtmlForm\Abstracts\Addable", $classes)) {
				$html .= $this->renderElements($element);
			} else if (in_array("HtmlForm\Elements\Parents\Html", $classes)) {
				$html .= $element->compile();
			} else {
				$value = $this->getValue($element);
				$html .= $this->beforeElement($element);
				$html .= $element->compile($value);
				$html .= $this->afterElement($element);
			}
		}

		$html .= $addable->getClosingTag();

		return $html;
	}
}
