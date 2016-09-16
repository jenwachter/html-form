<?php

namespace HtmlForm\Elements;

class RangeTest extends \PHPUnit_Framework_TestCase
{
	public function testCompile()
	{
    $field = new Range("test", "Test", 5, 10);

    $expected = "<label for=\"test\">Test</label><input type=\"number\" name=\"test\" min=\"5\" max=\"10\" value=\"\" />";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
