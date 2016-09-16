<?php

namespace HtmlForm\Elements;

class UrlTest extends \PHPUnit_Framework_TestCase
{
	public function testCompile()
	{
    $field = new Url("test", "Test");

    $expected = "<label for=\"test\">Test</label><input type=\"url\" name=\"test\"  value=\"\" />";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
