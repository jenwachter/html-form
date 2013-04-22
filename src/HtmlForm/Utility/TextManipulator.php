<?php

namespace HtmlForm\Utility;

class TextManipulator
{	
	/**
	 * Converts an associative array of
	 * key => value pairs into HTML tag attributes
	 *
	 * @param  array $array Array of key => value pairs
	 * @return string
	 */
	public function arrayToTagAttributes($array)
	{
		if (empty($array)) {
			return;
		}

		$attributes = array();
		foreach ($array as $k => $v) {
		    $attributes[] = "{$k}=\"{$v}\"";
		}
		
		return implode(" ", $attributes);
	}
}