<?php

namespace HtmlForm\Elements;

class TelTest extends \PHPUnit_Framework_TestCase
{
	public function testCompile()
	{
    $field = new Tel("test", "Test");

    $expected = "<label for=\"test\">Test</label><input type=\"tel\" name=\"test\"  value=\"\" />";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
