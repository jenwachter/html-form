<?php

namespace HtmlForm\Elements;

class TelTest extends \PHPUnit\Framework\TestCase
{
	public function testCompile()
	{
    $field = new Tel("test", "Test");

    $expected = "<label for=\"test_id\">Test</label><input id=\"test_id\" type=\"tel\" name=\"test\"  value=\"\" />";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
