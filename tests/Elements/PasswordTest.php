<?php

namespace HtmlForm\Elements;

class PasswordTest extends \PHPUnit\Framework\TestCase
{
	public function testCompile()
	{
    $field = new Password("test", "Test", ['required' => true]);

    $expected = "<label for=\"test_id\"><span class=\"required\">*</span> Test</label><input id=\"test_id\" type=\"password\" name=\"test\"  required value=\"\" />";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
