<?php

namespace HtmlForm\Utility;

class ValidatorTest extends \PHPUnit\Framework\TestCase
{
  public function testValidateHtmlAndAddable()
  {
    $validator = new Validator();
    $form = new \HtmlForm\Form();
    $fieldset = $form->addFieldset("testing");
    $fieldset->addText("test", "test");

    $result = $validator->validate($form);
    $this->assertTrue($result);
  }

  public function testValidateElement()
  {
    $validator = new Validator();
    $form = new \HtmlForm\Form();
    $form->addTextbox("testField", "test field", array("required" => true));
    $result = $validator->validate($form);
    $this->assertTrue($result);

    $validator = new Validator();
    $form = new \HtmlForm\Form();
    $form->addTextbox("test", "test", array("required" => true));
    $result = $validator->validate($form);
    $this->assertFalse($result);
  }

  public function testHoneypot()
  {
    $validator = new Validator();

    // test pass
    $form = new \HtmlForm\Form();
    $form->addHoneypot();
    $result = $validator->validate($form);
    $this->assertFalse($validator->honeypotError);

    // test fail
    $result = $validator->honeypot("string");
    $this->assertTrue($validator->honeypotError);
  }
}
