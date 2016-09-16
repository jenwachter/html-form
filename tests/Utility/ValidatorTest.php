<?php

namespace HtmlForm\Utility;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
  public function setUp()
  {
    $textbox = $this->getMockBuilder("\\HtmlForm\\Elements\\Textbox")
      ->disableOriginalConstructor()
      ->getMock();

    $range = $this->getMock("\\HtmlForm\\Elements\\Range", array(), array(
      "range", "range", 10, 20
    ));

    $pattern = $this->getMock("\\HtmlForm\\Elements\\Textbox", array(), array(
      "textbox", "textbox", array("attr" => array("pattern" => "/\d{4}/"))
    ));

    $this->mocks = array(
      "textbox" => $textbox,
      "range" => $range,
      "pattern" => $pattern
    );

    $this->testClass = new Validator();
  }

  public function testValidateHtmlAndAddable()
  {
    $form = new \HtmlForm\Form();
    $fieldset = $form->addFieldset("testing");
    $fieldset->addText("test", "test");

    $result = $this->testClass->validate($form);
    $this->assertEquals(array(), $result);
  }

  public function testHoneypot()
  {
    // test pass
    $form = new \HtmlForm\Form();
    $form->addHoneypot();

    $result = $this->testClass->validate($form);
    $this->assertEquals(array(), $result);

    // test fail
    $element = $this->mocks["pattern"];
    $result = $this->testClass->honeypot("label", "string", $element);
    $this->assertFalse($result);
  }

  public function testValidateElement()
  {
    // hit all the element checks

    // required validator
    $form = new \HtmlForm\Form();
    $form->addTextbox("testField", "test field", array("required" => true));
    $result = $this->testClass->validate($form);
    $this->assertEquals(array(), $result);

    // pattern
    $form = new \HtmlForm\Form();
    $form->addTextbox("testField", "test field", array(
      "required" => true,
      "attr" => array("pattern" => "/\w{4}")
    ));
    $result = $this->testClass->validate($form);
    $this->assertEquals(array(), $result);

    // class
    $form = new \HtmlForm\Form();
    $form->addNumber("number", "a number", array("required" => true));
    $result = $this->testClass->validate($form);
    $this->assertEquals(array(), $result);
  }

  public function testRequired()
  {
    $element = $this->mocks["textbox"];

    $result = $this->testClass->required("label", "", $element);
    $this->assertFalse($result);

    $result = $this->testClass->required("label", "a value", $element);
    $this->assertTrue($result);
  }

  public function testNumber()
  {
    $element = $this->mocks["textbox"];

    $result = $this->testClass->number("label", "a string", $element);
    $this->assertFalse($result);

    $result = $this->testClass->number("label", "11", $element);
    $this->assertTrue($result);

    $result = $this->testClass->number("label", 20, $element);
    $this->assertTrue($result);

    $result = $this->testClass->number("label", 20.5, $element);
    $this->assertTrue($result);
  }

  public function testRange()
  {
    $element = $this->mocks["range"];

    $result = $this->testClass->range("range", "NaN", $element);
    $this->assertFalse($result);

    $result = $this->testClass->range("range", 5, $element);
    $this->assertFalse($result);

    $result = $this->testClass->range("range", 15, $element);
    $this->assertTrue($result);
  }

  public function testUrl()
  {
    $element = $this->mocks["textbox"];

    $result = $this->testClass->url("label", "https://www.google.com", $element);
    $this->assertTrue($result);

    $result = $this->testClass->url("label", "www.google.com", $element);
    $this->assertFalse($result);
  }

  public function testEmail()
  {
    $element = $this->mocks["textbox"];

    $result = $this->testClass->email("label", "test@test.com", $element);
    $this->assertTrue($result);

    $result = $this->testClass->email("label", "test@test", $element);
    $this->assertFalse($result);
  }

  public function testPatern()
  {
    $element = $this->mocks["pattern"];

    $result = $this->testClass->pattern("label", "2016", $element);
    $this->assertTrue($result);

    $result = $this->testClass->pattern("label", "string", $element);
    $this->assertFalse($result);
  }
}
