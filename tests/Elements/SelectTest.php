<?php

namespace HtmlForm\Elements;

class SelectTest extends \PHPUnit\Framework\TestCase
{
	public function testCompile()
	{
    $field = new Select("test", "Test", array("test", "blue"), array("help" => "help text", 'required' => 'true'));

    $expected = "<label for=\"test_id\"><span class=\"required\">*</span> Test</label><div class='help'>help text</div><select id=\"test_id\" name=\"test\"  required><option value=\"test\" selected=\"selected\">test</option><option value=\"blue\" >blue</option></select>";
		$value = $field->compile("test");

    $this->assertEquals($expected, $value);
	}

	public function testCompileWithNumericValue()
	{
    $field = new Select("test", "Test", array("test", "blue"), array("useNumericValue" => true));

		$expected = "<label for=\"test_id\">Test</label><select id=\"test_id\" name=\"test\" ><option value=\"0\" selected=\"selected\">test</option><option value=\"1\" >blue</option></select>";
		$value = $field->compile(0);

		$this->assertEquals($expected, $value);
	}
}
