<?php

namespace HtmlForm\Elements;

class PasswordTest extends \PHPUnit\Framework\TestCase
{
	public function testCompile()
	{
    $field = new Password("test", "Test");

    $expected = "<label for=\"test_id\">Test</label><input id=\"test_id\" type=\"password\" name=\"test\"  value=\"\" />";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
