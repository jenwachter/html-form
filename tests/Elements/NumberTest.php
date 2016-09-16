<?php

namespace HtmlForm\Elements;

class NumberTest extends \PHPUnit_Framework_TestCase
{
	public function testCompile()
	{
    $field = new Number("test", "Test");

    $expected = "<label for=\"test\">Test</label><input type=\"number\" name=\"test\"  value=\"\" />";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
