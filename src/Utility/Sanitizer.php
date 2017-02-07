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

  /**
   * Apply a function to each value
   * @param  string $function Function name (ex: "stripslashes")
   * @param  array  $args     Function arguments
   * @return null
   */
  protected function apply($function, $args = array())
  {
    foreach ($this->data as $key => &$value) {

      if (!is_array($value)) {
        $value = $this->applyToValue($function, $args, $value);
      } else {
        $value = array_map(function ($v) use ($function, $args) {
          return $this->applyToValue($function, $args, $v);
        }, $value);
      }

    }
  }

  /**
   * Apply a function to a single form value
   * @param  string $function Function name
   * @param  array  $args     Function arguments
   * @param  string $value    Value to apply functon to
   * @return string Sanitized value
   */
  protected function applyToValue($function, $args, $value)
  {
    array_unshift($args, $value);
    return call_user_func_array($function, $args);
  }

  /**
   * Strip slashes from data
   * @return object self
   */
  public function stripslashes()
  {
    $this->apply("stripslashes");
    return $this;
  }
  
  /**
   * Convert special characters to HTML entities
   * @return object self
   */
  public function htmlspecialchars()
  {
    $this->apply("htmlspecialchars");
    return $this;
  }

  /**
   * Remove tags from data
   * @param  array  $except Array of tags ex: <br>
   * @return object self
   */
  public function striptags($except = array())
  {
    $except = implode("", $except);
    $this->apply("strip_tags", array($except));
    return $this;
  }
}
