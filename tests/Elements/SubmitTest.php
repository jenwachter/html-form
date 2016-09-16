<?php

namespace HtmlForm\Elements;

class SubmitTest extends \PHPUnit_Framework_TestCase
{
	public function testCompile()
	{
    $field = new Submit("test", "Test");

    $expected = "<input type=\"submit\" name=\"test\"  value=\"Test\" />";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
