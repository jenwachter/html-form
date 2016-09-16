<?php

namespace HtmlForm\Elements;

class RadioTest extends \PHPUnit_Framework_TestCase
{
	public function testCompile()
	{
    $field = new Radio("test", "Test", array("test", "blue"));

    $expected = "<label for=\"test\">Test</label><div class=\"elements\"><div class=\"element\"><input type=\"radio\"  name=\"test\" value=\"test\"  /> <span>test</span></div><div class=\"element\"><input type=\"radio\"  name=\"test\" value=\"blue\"  /> <span>blue</span></div></div>";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
