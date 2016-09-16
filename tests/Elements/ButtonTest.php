<?php

namespace HtmlForm\Elements;

class ButtonTest extends \PHPUnit_Framework_TestCase
{
  public function testCompile()
	{
    $field = new Button("testField", "Test Field", array(
      "attr" => array("something" => "cool"),
      "help" => "help text"
    ));

		$expected = "<input type=\"button\" name=\"testField\" something=\"cool\" value=\"Test Field\" /><div class='help'>help text</div>";
		$this->assertEquals($expected, $field->compile());
	}
}
