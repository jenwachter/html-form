<?php

namespace HtmlForm\Utility;

class SanitizerTest extends \PHPUnit\Framework\TestCase
{
  public function testSanitize()
  {
    $given = array(
      "field1" => "<p>A <strong>string</strong> with an <script></script>escaped apostrophe: it\'s</p>",
      "field2" => array(
        "it\'s cool",
        "yeah it\'s cool"
      )
    );

    $expected = array(
      "field1" => "<p>A <strong>string</strong> with an escaped apostrophe: it's</p>",
      "field2" => array(
        "it's cool",
        "yeah it's cool"
      )
    );

    $sanitizer = new Sanitizer($given);

    $sanitizer
      ->stripslashes()
      ->striptags(array("<p>", "<strong>"));

    $this->assertEquals($expected, $sanitizer->data);
  }
}
