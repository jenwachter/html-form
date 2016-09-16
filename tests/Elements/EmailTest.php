<?php

namespace HtmlForm\Elements;

class EmailTest extends \PHPUnit_Framework_TestCase
{
	public function testCompile()
	{
    $field = new Email("test", "Test");

    $expected = "<label for=\"test\">Test</label><input type=\"email\" name=\"test\"  value=\"\" />";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
