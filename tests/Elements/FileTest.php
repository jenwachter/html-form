<?php

namespace HtmlForm\Elements;

class FileTest extends \PHPUnit\Framework\TestCase
{
	public function testCompile()
	{
    $field = new File("test", "Test", ['required' => true]);

    $expected = "<label for=\"test_id\"><span class=\"required\">*</span> Test</label><input id=\"test_id\" type=\"file\" name=\"test\"  required value=\"\" />";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
