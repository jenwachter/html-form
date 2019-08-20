<?php

namespace HtmlForm\Elements;

class RadioTest extends \PHPUnit\Framework\TestCase
{
	public function testCompile()
	{
    $field = new Radio("test", "Test", array("test", "blue"));

    $expected = "<div class=\"label\">Test</div><div class=\"elements\"><div class=\"element\"><label><input type=\"radio\"  name=\"test\" value=\"test\"  /> <span>test</span></label></div><div class=\"element\"><label><input type=\"radio\"  name=\"test\" value=\"blue\"  /> <span>blue</span></label></div></div>";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
