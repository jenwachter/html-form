<?php

namespace HtmlForm\Elements;

class TimeTest extends \PHPUnit\Framework\TestCase
{
	public function testCompile()
	{
    $field = new Time("test", "Test", ['required' => true]);

    $expected = "<label for=\"test_id\"><span class=\"required\">*</span> Test</label><input id=\"test_id\" type=\"time\" name=\"test\"  required value=\"\" />";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
