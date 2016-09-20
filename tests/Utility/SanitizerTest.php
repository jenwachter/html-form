<?php

namespace HtmlForm\Utility;

class SanitizerTest extends \PHPUnit_Framework_TestCase
{
  public function testValidateHtmlAndAddable()
  {
    $given = array(
      "field1" => "A string with an escaped apostrophe: it\'s",
      "field2" => array(
        "it\'s cool",
        "yeah it\'s cool"
      )
    );

    $expected = array(
      "field1" => "A string with an escaped apostrophe: it's",
      "field2" => array(
        "it's cool",
        "yeah it's cool"
      )
    );

    $sanitizer = new Sanitizer($given);

    $sanitizer
      ->stripslashes();

    $this->assertEquals($expected, $sanitizer->data);
  }
}
