<?php

namespace HtmlForm\Utility;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
  public function testValidateHtmlAndAddable()
  {
    $validator = new Validator();

    $form = new \HtmlForm\Form();
    $fieldset = $form->addFieldset("testing");
    $fieldset->addText("test", "test");

    $result = $validator->validate($form);
    $this->assertEquals(array(), $result);
  }

  public function testHoneypot()
  {
    $validator = new Validator();

    $form = new \HtmlForm\Form();
    $form->addHoneypot();

    $result = $validator->validate($form);
    $this->assertEquals(array(), $result);
  }

  public function testValidateElement()
  {
    // hit all the element checks

    $validator = new Validator();

    // required validator
    $form = new \HtmlForm\Form();
    $form->addTextbox("testField", "test field", array("required" => true));
    $result = $validator->validate($form);
    $this->assertEquals(array(), $result);

    // pattern
    $form = new \HtmlForm\Form();
    $form->addTextbox("testField", "test field", array(
      "required" => true,
      "attr" => array("pattern" => "/\w{4}")
    ));
    $result = $validator->validate($form);
    $this->assertEquals(array(), $result);

    // class
    $form = new \HtmlForm\Form();
    $form->addNumber("number", "a number", array("required" => true));
    $result = $validator->validate($form);
    $this->assertEquals(array(), $result);
  }
}
