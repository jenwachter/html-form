<?php

namespace HtmlForm;

class FormTest extends \PHPUnit\Framework\TestCase
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

		$this->assertStringContainsString($expected, $result);
	}

	public function testRender()
	{
		$form = new \HtmlForm\Form(array("attr" => array("something" => "cool")));

		$fieldset = $form->addFieldset("The Legend");
		$fieldset->addTextbox("firstName", "first name", array(
			"required" => true,
			"beforeElement" => "<div class=\"form_field clearfix\">",
			"afterElement" => "</div>",
			"help" => "help text"
		));
		$fieldset->addTextbox("testField", "test field");
		$form->addText("testing", "<p>testing text</p>");
		$form->addHoneypot();

		$expected = '<form method="post" action="index.php?test=aha" id="hfc" something="cool"><fieldset><legend>The Legend</legend><div class="form_field clearfix"><label for="firstName_id"><span class=\'required\'>*</span> first name</label><div class=\'help\'>help text</div><input id="firstName_id" type="text" name="firstName"  value="" /></div><label for="testField_id">test field</label><input id="testField_id" type="text" name="testField"  value="test" /></fieldset><p>testing text</p><div class="honeypot" style="display: none;"><input type="text" name="b2cedb9c4cedce6bd311f6e9c2c861e31dd3baf2"  value="" /></div></form>';

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
}
