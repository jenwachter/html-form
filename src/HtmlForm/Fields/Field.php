<?php

namespace HtmlForm\Fields;

abstract class Field implements \HtmlForm\Interfaces\Field
{
	public $requiredSymbol = "*";

	public abstract function compile($field);

	/**
     * Gets the HTML for the label of a form element
     * @param  array $field An array of variables that define the form element
     * @return string 		The form element"s HTML label
     */
	public function compileLabel($field)
	{	
		if (empty($field["label"])) return false;
		
		$required = !empty($field["required"]) ? $this->requiredSymbol : "";
		$name = $field["name"];
		$label = $field["label"];

		return "<label for=\"{$name}\">{$required}{$label}</label>";
	}
	
    /**
     * Fetches the HTML attributes of a form element
     * @param  array $field 	An array of variables that define the form element
     * @return string 			The form element"s attributes
     */
	public function compileAttributes($field)
	{
		$attr = array();
		
		$attr["class"] = "";
		$attr["class"] .= $field["required"] ? "required " : "";
		$attr["class"] .= $field["attr"]["class"] ? $field["attr"]["class"] : "";
		
		$attributes = "";
		foreach ($attr as $k => $v) {
		    $attributes .= "{$k}=\"{$v}\" ";
		}
		
		return $attributes;
	}

	/**
     * Gets the current value attribute of a form element
     * @param  array $field 	An array of variables that define the form element
     * @return string 			The form element"s current value
     */
	public function getValue($field)
	{	
		// if (isset($_SESSION[$this->config["id"]][$field["name"]])) {
		// 	return stripslashes($_SESSION[$this->config["id"]][ $field["name"] ] );
			
		// } else if (isset($_POST[$field["name"]])) {
		// 	return stripslashes($_POST[$field["name"]]);
		
		// } else {	
			return stripslashes($field["value"]);
		// }
	}
}