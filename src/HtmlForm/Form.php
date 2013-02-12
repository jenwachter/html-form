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
			"attr" => array()
		);

		$this->config = array_merge($this->config, $config);
	}
	
	/**
	 * Get HTML to display before a form element
	 */
	public function beforeElement($classes = array())
	{
		$classes = !empty($classes) ? implode(" ", $classes) : "";
		return "<div class=\"form_field clearfix {$classes}\">";
	}
	
	/**
	 * Get HTML to display after a form element
	 */
	public function afterElement()
	{
		return "</div>";
	}



	/**
     * Gets the current value attribute of a form element
     * @param  array $name 	Name of the form field
     * @return string 		The form element"s current value
     */
	public function getValue($name)
	{	
		if (isset($_SESSION[$this->config["id"]][$name])) {
			return stripslashes($_SESSION[$this->config["id"]][$name] );
			
		} else if (isset($_POST[$name])) {
			return stripslashes($_POST[$name]);
		
		} else {	
			return stripslashes($field["value"]);
		}
	}

	public function addTextbox($name, $args = array())
	{
		$element = new \HtmlForm\Fields\Text($name, $args);
		$this->formElements[] = $element;
	}

	public function addTextarea($name, $args = array())
	{
		$element = new \HtmlForm\Fields\Textarea($name, $args);
		$this->formElements[] = $element;
	}

	public function addSelect($name, $args = array())
	{
		$element = new \HtmlForm\Fields\Select($name, $args);
		$this->formElements[] = $element;
	}

	public function addRadio($name, $args = array())
	{
		$element = new \HtmlForm\Fields\Radio($name, $args);
		$this->formElements[] = $element;
	}

	public function addCheckbox($name, $args = array())
	{
		$element = new \HtmlForm\Fields\Checkbox($name, $args);
		$this->formElements[] = $element;
	}

	public function addButton($name, $args = array())
	{

	}

	/**
	 * Defines the form element to be created and adds it to the $formElements array
     * @param array $field an array that defines the form element
     * @return null
     */
	public function addElement($field = array())
	{
		
		// create defaults for all possibilities
		$defaults = array (
			"name"			=> "",
			"label"			=> "",
			"value"			=> "",
			"required"		=> false,
			"attr"			=> array ("class" => ""),
			"options"		=> array ()
		);
		
		// merge with the actual values sent to the function
		$field = array_merge($defaults, $field);
		$field["attr"] = array_merge($defaults["attr"], $field["attr"]);
		$field["options"] = array_merge($defaults["options"], $field["options"]);
		
		$this->formElements[] = array(
			"field"	=> $field,
				"id" => $field["name"]
		);
	}
	
	
	/* checks basic validity of the form and enables repopulating
     * @return array of fields with errors
     */
	public function isValid()
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$data = $_POST;
		} else {
			$data = $_GET;
		}
		
		if ($this->config["repopulate"]) {
			foreach ($data as $k => $v) {
				$_SESSION[$this->config["id"]][$k] = $v;
			}
		}
		
		
		// empty array
		$this->validationErrors = array();
		
		foreach ($this->formElements as $k => $v) {
			
			if (isset($v["field"])) {
				
				// validate required fields
				if ( $v["field"]["required"] ) {
					
					if (!isset($_POST[$v["field"]["name"]]) || $_POST[$v["field"]["name"]] == "") {
						$this->validationErrors[] = $v["field"]["label"] . " is a required field.";
					}
				}
			}
		}
		
		return $this->validationErrors;
	}
	
	
	
	/**
	 * Renders the entire HTML form
     * @return null
     */
	public function render()
	{
		// // see if there is a file field. if so, change the entype
		// foreach ($this->formElements as $k => $v) {
			
		// 	if (isset($v["field"]["type"]) && $v["field"]["type"] == "file") {
		// 		$this->config["attr"]["enctype"] = "multipart/form-data";
		// 		break;
		// 	}
		// }
		
		// get the form attributes
		$attributes = "";
		// foreach ( $this->config["attr"] as $k => $v ) {
		//     $attributes .= "{$k}=\"{$v}\" ";
		// }
		
		
		// if (isset($this->validationErrors) && !empty($this->validationErrors)) {
			
		// 	$count = count($this->validationErrors);
		// 	$message = $count > 1 ? "The following {$count} errors were found:" : "The following error was found:";
			
		// 	echo "<div class=\"alert alert-error {$this->config["id"]}\">";
		// 	echo "<p class=\"alert-heading\">{$message}</p>";
		// 	echo "<ul>";
			
		// 	foreach ($this->validationErrors as $k => $v) {
		// 		echo "<li>{$v}</li>";
		// 	}
			
		// 	echo "</ul>";
		// 	echo "</div>";
			
		// }
		
		$html = "";
		$html .= "<form method=\"{$this->config["method"]}\" action=\"{$this->config["action"]}\" id=\"{$this->config["id"]}\" {$attributes}>";

		// render each form element
		foreach ($this->formElements as $element) {
			$html .= $element->compile();
		}
		
		$html .= "</form>";

		echo $html;
	}
	
}

?>