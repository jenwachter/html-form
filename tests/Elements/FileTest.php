<?php

namespace HtmlForm\Elements;

class FileTest extends \PHPUnit\Framework\TestCase
{
	public function testCompile()
	{
    $field = new File("test", "Test");

    $expected = "<label for=\"test_id\">Test</label><input id=\"test_id\" type=\"file\" name=\"test\"  value=\"\" />";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
