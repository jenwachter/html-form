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
	protected $form_elements = array();
	
	/**
	 * Stores validation errors
	 */
	protected $val_errors = array();
		

	public function __construct($config)
	{
		$action = $_SERVER["QUERY_STRING"] ? $_SERVER["PHP_SELF"] . "?" . $_SERVER["QUERY_STRING"] : $_SERVER["PHP_SELF"];
		
		$this->config = array(
			"method" => "post",
			"action" => $action,
			"id" => "hfc",
			"repopulate" => true,
			"show_form_tag" => true,
			"attr" => array()
		);

		$this->config = array_merge($this->config, $config);

		$this->tempField = new \HtmlForm\Fields\Input();
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
	 * Inserts an element at a specific location in an array
	 *
     * @param array $source the array to insert data into
     * @param array $insert the array to insert into $source
     * @param number $position the numeric position to enter $insert into $source
     * @param number $replace the number of elements for $insert to replace
     * @return boolean
     */
	protected function arrayInsert($source, $insert, $position, $replace = 0)
	{
		if (count($source) < $position) return false;
		array_splice($source, $position, 0, $insert);
		return $source;
	}

	
	
	
	
	
	
	
	
	/**
	 * Defines the form element to be created and adds it to the $form_elements array
     * @param array $field an array that defines the form element
     * @return null
     */
	public function addElement($field = array(), $position = "")
	{
		
		// create defaults for all possibilities
		$defaults = array (
			"type"			=> "text", // text, hidden, textarea, select, radio, file, password, checkbox, button
			"name"			=> "",
			"label"			=> "",
			"value"			=> "",
			"required"		=> false,
			"attr"			=> array ( "class" => "" ),
			"options"		=> array (),
			"prepend"		=> "",
			"append"		=> "",
			"inline_help"	=> ""
		);
		
		// merge with the actual values sent to the function
		$field = array_merge($defaults, $field);
		$field["attr"] = array_merge($defaults["attr"], $field["attr"]);
		$field["options"] = array_merge($defaults["options"], $field["options"]);
		
		if ( is_int( $position ) ) {
			$this->form_elements = $this->arrayInsert( $this->form_elements, array (
				array (
					"field" => $field,
					"id" => $field["name"]
				)
			), $position );
			
		} else {
			$this->form_elements[] = array(
				"field"	=> $field,
					"id" => $field["name"]
			);
		}
		
	}
	
	
	/**
	 * Adds content other than form elements to the form
     * @param string $content a string of html
     * @return null
     */
	public function addContent($content, $id = "", $position = "")
	{
		$id = $id ? $id : count($this->form_elements);
		
		if (is_int($position)) {
			$this->form_elements = $this->arrayInsert($this->form_elements, array (
				array(
					"html" => $content,
					"id" => $id
				)
			), $position);
			
		} else {
			$this->form_elements[] = array(
				"html" => $content,
				"id" => $id
			);
		}
	}
	
	/**
	 * Removes a form element based on the form element"s name
     * @param string form element id
     * @return null
     */
	public function removeElement($id)
	{
		foreach ($this->form_elements as $k => $v) {		
			if ($v["id"] === $id) {
				unset($this->form_elements[$k]);
			}
		}
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
		$this->val_errors = array();
		
		foreach ($this->form_elements as $k => $v) {
			
			if (isset($v["field"])) {
				
				// validate required fields
				if ( $v["field"]["required"] ) {
					
					if (!isset($_POST[$v["field"]["name"]]) || $_POST[$v["field"]["name"]] == "") {
						$this->val_errors[] = $v["field"]["label"] . " is a required field.";
					}
				}
			}
		}
		
		return $this->val_errors;
	}
	
	
	
	/**
	 * Renders the entire HTML form
     * @return null
     */
	public function render()
	{		
		// see if there is a file field. if so, change the entype
		foreach ($this->form_elements as $k => $v) {
			
			if (isset( $v["field"]["type"]) && $v["field"]["type"] == "file") {
				$this->config["attr"]["enctype"] = "multipart/form-data";
				break;
			}
		}
		
		// get the form attributes
		$attributes = "";
		foreach ( $this->config["attr"] as $k => $v ) {
		    $attributes .= "{$k}=\"{$v}\" ";
		}
		
		
		if (isset($this->val_errors) && !empty($this->val_errors)) {
			
			$count = count($this->val_errors);
			$message = $count > 1 ? "The following {$count} errors were found:" : "The following error was found:";
			
			echo "<div class=\"alert alert-error {$this->config["id"]}\">";
			echo "<p class=\"alert-heading\">{$message}</p>";
			echo "<ul>";
			
			foreach ($this->val_errors as $k => $v) {
				echo "<li>{$v}</li>";
			}
			
			echo "</ul>";
			echo "</div>";
			
		}
		
		if ($this->config["show_form_tag"]) {
			echo "<form method=\"{$this->config["method"]}\" action=\"{$this->config["action"]}\" id=\"{$this->config["id"]}\" {$attributes}>";
		}

		// render each form element
		foreach ($this->form_elements as $k => $v) {
			
			// for addContent elements
			if (isset( $v["html"])) {
				echo $v["html"];
			}
			
			// for addElement elements
			if (isset( $v["field"])) {
				
				$html = "";
				
				if ($v["field"]["type"] != "hidden") {
					
					$classes = "";
					
					if ($v["field"]["prepend"] != "" )
						$classes .= " input-prepend";
						
					if ($v["field"]["append"] != "")
						$classes .= " input-append";
					
					$html .= $this->beforeElement($classes);
				}
				
				$html .= $this->tempField->compileLabel($v["field"]);
				
				if ($v["field"]["prepend"] != "") {
					$html .= "<span class=\"add-on\">" . $v["field"]["prepend"] . "</span>";
				}
				
				switch( $v["field"]["type"] ) {
					case "textarea":
						$textarea = new \HtmlForm\Fields\Textarea();
						$html .= $textarea->compile($v["field"]);
						break;
					case "select":
						$select = new \HtmlForm\Fields\Select();
						$html .= $select->compile($v["field"]);		
						break;
					case "button":
					case "checkbox":
					case "file":
					case "hidden":
					case "image":
					case "password":
					case "radio":
					case "reset":
					case "submit":
					case "text":
						$input = new \HtmlForm\Fields\Input();
						$html .= $input->compile($v["field"]);
						break;
				}
				
				if ($v["field"]["append"] != "") {
					$html .= "<span class=\"add-on\">" . $v["field"]["append"] . "</span>";
				}
				
				if($v["field"]["inline_help"] != "") {
					$html .= "<span class=\"help-inline\">" . $v["field"]["inline_help"] . "</span>";
				}
				
				if ($v["field"]["type"] != "hidden") {
					$html .= $this->afterElement();
				}

				echo $html;
			}
			
		}
		
		if ($this->config["show_form_tag"]) {
			echo "</form>";
		}
	}
	
}

?>