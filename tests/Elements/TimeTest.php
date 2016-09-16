<?php

namespace HtmlForm\Elements;

class TimeTest extends \PHPUnit_Framework_TestCase
{
	public function testCompile()
	{
    $field = new Time("test", "Test");

    $expected = "<label for=\"test\">Test</label><input type=\"time\" name=\"test\"  value=\"\" />";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
