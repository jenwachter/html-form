<?php

namespace HtmlForm\Elements;

class HiddenTest extends \PHPUnit\Framework\TestCase
{
	public function testCompile()
	{
    $field = new Hidden("test", "Test");

    $expected = "<input type=\"hidden\" name=\"test\"  value=\"\" />";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
