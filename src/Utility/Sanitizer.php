<?php

namespace HtmlForm\Utility;

class Sanitizer
{
  /**
   * Data passed to sanitizer
   * @var array
   */
  public $data = array();

  /**
   * Constructor
   * @param array $data Form data
   */
  public function __construct($data = array())
  {
    $this->data = $data;
  }

  public function stripslashes()
  {
    foreach ($this->data as $key => &$value) {
      $value = stripslashes($value);
    }

    return $this;
  }
}
