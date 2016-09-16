<?php

namespace HtmlForm\Elements;

class PasswordTest extends \PHPUnit_Framework_TestCase
{
	public function testCompile()
	{
    $field = new Password("test", "Test");

    $expected = "<label for=\"test\">Test</label><input type=\"password\" name=\"test\"  value=\"\" />";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
