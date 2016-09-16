<?php

namespace HtmlForm\Elements;

class TextTest extends \PHPUnit_Framework_TestCase
{
	public function testCompile()
	{
    $field = new Text("test", "Test");

    $expected = "Test";
		$value = $field->compile();

    $this->assertEquals($expected, $value);
	}

}
