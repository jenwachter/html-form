<?php
session_start();

//unset($_SESSION['hfc']);

require_once 'class_html_form.php';

$form = new html_form;

$form->add_content('<fieldset><legend>Reserve a Ticket</legend>');

$form->add_element( array (
	'type'		=> 'text',
	'name'		=> 'text_element',
	'label'		=> 'Text Element',
	'required'	=> true,
	'attr'		=> array ( 'maxlength' => '255')
));

$form->add_element( array (
	'type'		=> 'password',
	'name'		=> 'password_element',
	'label'		=> 'Password Element',
	'required'	=> true,
	'attr'		=> array ( 'maxlength' => '255')
));

$form->add_element( array (
	'type'		=> 'textarea',
	'name'		=> 'textarea_element',
	'label'		=> 'Textarea Element'
));

$form->add_element( array (
	'type'		=> 'file',
	'name'		=> 'file_element',
	'label'		=> 'File Element'
));

$form->add_element( array (
	'type'		=> 'checkbox',
	'name'		=> 'checkbox_element',
	'label'		=> 'Checkbox Element',
	'options'	=> array (
		'test1', 'test2', 'test3', 'test4'
	)
));

$form->add_element( array (
	'type'		=> 'select',
	'name'		=> 'select_element',
	'label'		=> 'Select Element',
	'options'	=> array (
		'firefox', 'chrome', 'safari', 'ie'
	)
));

$form->add_element( array (
	'type'		=> 'radio',
	'name'		=> 'radio_element',
	'label'		=> 'Radio Element',
	'options'	=> array (
		'blue'		=> 'blueberries',
		'red'		=> 'strawberries',
		'purple'	=> 'grapes'
	)
));

$form->add_element( array (
	'type'		=> 'button',
	'name'		=> 'button_element',
	'value'		=> 'Button Element'
));

$form->add_content('</fieldset>');

$form->add_element( array (
	'type'		=> 'hidden',
	'name'		=> 'hidden_element',
	'value'		=> 'this field is hidden'
));

$form->add_element( array (
	'type'		=> 'submit',
	'name'		=> 'submit',
	'value'		=> 'Submit'
));

if ( isset( $_POST['submit'] ) ) {
	$form->isValid();
}

$form->add_element( array (
	'type'		=> 'text',
	'name'		=> 'text_element_insert',
	'label'		=> 'Text Element INSERT'
), 5);


?>

<link rel="stylesheet" href="style.css" />


<?php $form->render(); ?>

<pre>
<?php print_r($_SESSION); ?>
</pre>