<?php

namespace HtmlForm\Elements;

class FileTest extends \PHPUnit_Framework_TestCase
{
	public function testCompile()
	{
    $field = new File("test", "Test");

    $expected = "<label for=\"test\">Test</label><input type=\"file\" name=\"test\"  value=\"\" />";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
