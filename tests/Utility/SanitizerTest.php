<?php

namespace HtmlForm\Utility;

class SanitizerTest extends \PHPUnit_Framework_TestCase
{
  public function testValidateHtmlAndAddable()
  {
    $given = array(
      "field1" => "A string with an escaped apostrophe: word\'s"
    );

    $expected = array(
      "field1" => "A string with an escaped apostrophe: word's"
    );

    $sanitizer = new Sanitizer($given);

    $sanitizer
      ->stripslashes();

    $this->assertEquals($expected, $sanitizer->data);
  }
}
