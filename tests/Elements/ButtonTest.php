<?php

namespace HtmlForm\Elements;

class ButtonTest extends \PHPUnit\Framework\TestCase
{
  public function testCompile()
	{
    $field = new Button("testField", "Test Field", array(
      "attr" => array("something" => "cool"),
      "help" => "help text"
    ));

		$expected = "<div class='help'>help text</div><input type=\"button\" name=\"testField\" something=\"cool\" value=\"Test Field\" />";
		$this->assertEquals($expected, $field->compile());
	}
}
