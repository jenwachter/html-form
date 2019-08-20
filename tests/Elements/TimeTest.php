<?php

namespace HtmlForm\Elements;

class TimeTest extends \PHPUnit\Framework\TestCase
{
	public function testCompile()
	{
    $field = new Time("test", "Test");

    $expected = "<label for=\"test_id\">Test</label><input id=\"test_id\" type=\"time\" name=\"test\"  value=\"\" />";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
