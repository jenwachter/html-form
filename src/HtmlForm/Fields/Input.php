<?php

namespace HtmlForm\Fields;

class Input extends Field
{
	/**
     * Creates an input form element
     * @param  array $field 	An array of variables that define the form element
     * @return string 			The form element"s HTML
     */
	public function compile($field)
	{
		$html = "";
		$value = $this->getValue($field);
		
		
		switch ($field["type"]) {
			case "checkbox":
			case "radio":
				
				$html .= "<div class=\"{$field["type"]}_group\">";
				
				/* check to see if the options are an associative array
				   this will determine how we handle the input value */
				$isAssoc = \HtmlForm\Utility::isAssoc($field["options"]);
				
				foreach ($field["options"] as $k => $v) {
					
					$html .= "<span class=\"" . $field["type"] . "\">";
					
					$html .= "<input type=\"" . $field["type"] . "\" ";
					$html .= $this->compileAttributes( $field );
					
					// if a checkbox, make the $_POST key of $field["name"] an array
					if ($field["type"] == "checkbox") {
						$html .= "name=\"" . $field["name"] . "[]\" ";
					} else {
						$html .= "name=\"" . $field["name"] . "\" ";
					}
					
					// handle options in an associative array differently than ones in a numeric array
					if ($isAssoc) {
						$html .= "value=\"{$k}\" ";
						if ($k == $value || (is_array($value) && in_array($k, $value)))
							$html .= " checked=\"checked\"";
					
					} else {
						$html .= "value=\"{$v}\" ";
						if ($v == $value || (is_array($value) && in_array($v, $value)))
							$html .= " checked=\"checked\"";
					}
					
					$html .= " /> {$v}</span>";
				}
				
				$html .= "</div>";
				break;
				
			default:
				$html .= "<input type=\"" . $field["type"] . "\" ";
				$html .= "name=\"" . $field["name"] . "\" ";
				$html .= $this->compileAttributes($field);
				$html .= "value=\"{$value}\" />";
				break;
				
			/*	
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
			*/
			
		}
		return $html;
	}
}