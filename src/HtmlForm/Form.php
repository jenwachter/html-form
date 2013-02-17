<?php

namespace HtmlForm;

class Form {
	
	/**
	 * Stores form configuration
	 * @var array
	 */
	protected $config = array();
	
	/**
	 * Stores form elements added to the form in sequencial order
	 */
	protected $formElements = array();
	
	/**
	 * Stores validation errors
	 */
	protected $validationErrors = array();
		

	public function __construct($config = array())
	{
		// default to self + query string
		$action = $_SERVER["QUERY_STRING"] ? $_SERVER["PHP_SELF"] . "?" . $_SERVER["QUERY_STRING"] : $_SERVER["PHP_SELF"];
		
		$this->config = array(
			"method" => "post",
			"action" => $action,
			"id" => "hfc",
			"repopulate" => true,
			"attr" => array(),
			"beforeElement" => "",
			"afterElement" => ""
		);

		$this->config = array_merge($this->config, $config);
	}

	protected function beforeElement($element)
	{
		return $element->beforeElement ? $element->beforeElement : $this->config["beforeElement"];
	}

	protected function afterElement($element)
	{
		return $element->afterElement ? $element->afterElement : $this->config["afterElement"];
	}


	public function __call($method, $args)
	{
		if (!preg_match("/^add([a-zA-Z]+)/", $method, $matches)) {
			return false;
		}

		$className = "\\HtmlForm\\Elements\\{$matches[1]}";
		
		if (class_exists($className)) {
			$reflect  = new \ReflectionClass($className);
			$element = $reflect->newInstanceArgs($args);
			$this->formElements[] = $element;
		}
	}
	
	/* checks basic validity of the form and enables repopulating
     * @return array of fields with errors
     */
	public function validate()
	{
		$data = $_SERVER["REQUEST_METHOD"] == "POST" ? $_POST : $_GET;
		
		// Save the data in the session
		if ($this->config["repopulate"]) {
			foreach ($data as $k => $v) {
				$_SESSION[$this->config["id"]][$k] = $v;
			}
		}

		$validator = new \HtmlForm\Utility\Validator($this->formElements);
		$this->validationErrors = $validator->validate();
	}
	



	/**
     * Gets the current value attribute of a form element
     * @param  object $name 	Form element object
     * @return string 			The form element's current value
     */
	public function getValue($element)
	{	
		$name = $element->name;

		if (isset($_SESSION[$this->config["id"]][$name])) {
			return stripslashes($_SESSION[$this->config["id"]][$name] );
			
		} else if (isset($_POST[$name])) {
			return stripslashes($_POST[$name]);
		
		} else {	
			return stripslashes($element->defaultValue);
		}
	}
	
	/**
	 * Renders the entire HTML form
     * @return null
     */
	public function render()
	{
		// get the form attributes
		$attributes = "";
		foreach ( $this->config["attr"] as $k => $v ) {
		    $attributes .= "{$k}=\"{$v}\" ";
		}
		
		
		if (isset($this->validationErrors) && !empty($this->validationErrors)) {
			
			$count = count($this->validationErrors);
			$message = $count > 1 ? "The following {$count} errors were found:" : "The following error was found:";
			
			echo "<div class=\"alert alert-error {$this->config["id"]}\">";
			echo "<p class=\"alert-heading\">{$message}</p>";
			echo "<ul>";
			
			foreach ($this->validationErrors as $k => $v) {
				echo "<li>{$v}</li>";
			}
			
			echo "</ul>";
			echo "</div>";
			
		}
		
		$html = "";
		$html .= "<form novalidate=\"novalidate\" method=\"{$this->config["method"]}\" action=\"{$this->config["action"]}\" id=\"{$this->config["id"]}\" {$attributes}>";

		// render each form element
		foreach ($this->formElements as $element) {
			$value = $this->getValue($element);
			$html .= $this->beforeElement($element);
			$html .= $element->compile($value);
			$html .= $this->afterElement($element);
		}
		
		$html .= "</form>";

		echo $html;
	}
	
}

?>