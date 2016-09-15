<?php

namespace HtmlForm;

class FormTest extends \PHPUnit_Framework_TestCase
{
	public function testSetConfigWithNoUserConfig()
	{
		$form = new \HtmlForm\Form();

		$given = array();

		$expected = array(
			"action" => "index.php?test=aha",
			"id" => "hfc",
			"repopulate" => true,
			"attr" => array(),
			"beforeElement" => "",
			"afterElement" => ""
		);

		$result = $form->setConfig($given);
		$this->assertEquals($expected, $form->config);
	}

	public function testSetConfigWithData()
	{
		$form = new \HtmlForm\Form();

		$given = array(
			"action" => "otherPage.php"
		);

		$expected = array(
			"action" => "otherPage.php",
			"id" => "hfc",
			"repopulate" => true,
			"attr" => array(),
			"beforeElement" => "",
			"afterElement" => ""
		);

		$result = $form->setConfig($given);
		$this->assertEquals($expected, $form->config);
	}

	public function testSetErrorMessage()
	{
		$form = new \HtmlForm\Form();

		$given = "My custom error.";
		$expected = '<div class="alert alert-error"><p class="alert-heading">The following error was found:</p><ul><li>My custom error.</li></ul></div><form method="post" action="index.php?test=aha" id="hfc" ></form>';

		$form->setErrorMessage($given);
		$result = $form->render();

		$this->assertContains($expected, $result);
	}

	public function testRender()
	{
		$form = new \HtmlForm\Form();

		$fieldset = $form->addFieldset("The Legend");
		$fieldset->addTextbox("firstName", "first name", array(
			"required" => true,
			"beforeElement" => "<div class=\"form_field clearfix\">",
			"afterElement" => "</div>"
		));
		$form->addText("testing", "<p>testing text</p>");
		$form->addHoneypot();

		$expected = '<form method="post" action="index.php?test=aha" id="hfc" ><fieldset><legend>The Legend</legend><div class="form_field clearfix"><label for="firstName"><span class=\'required\'>*</span> first name</label><input type="text" name="firstName"  value="" /></div></fieldset><p>testing text</p><div class="honeypot" style="display: none;"><input type="text" name="b2cedb9c4cedce6bd311f6e9c2c861e31dd3baf2"  value="" /></div></form>';

		$result = $form->render();
		$this->assertEquals($expected, $result);
	}

	public function testRenderWithEmptyForm()
	{
		$form = new \HtmlForm\Form();

		$expected = '<form method="post" action="index.php?test=aha" id="hfc" ></form>';

		$result = $form->render();
		$this->assertEquals($expected, $result);
	}

	public function testIsValidNoValue()
	{
		$form = new \HtmlForm\Form(array("repopulate" => true));
		$form->addTextbox("firstName", "first name", array("required" => true));

		// no value found in post, returns false
		$result = $form->isValid();
		$this->assertFalse($result);
	}

	public function testIsValidPostValue()
	{
		$form = new \HtmlForm\Form(array("repopulate" => true));
		$form->addTextbox("testField", "test field", array("required" => true));

		// post value, return true
		$result = $form->isValid();
		$this->assertTrue($result);
	}
}
