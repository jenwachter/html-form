# HTML Form
The HTML Form Class was designed to make creating, validating, and maintaining forms easier. Still a work-in-progress, some features are still slim.

## Requirements

1. Sessions enabled


## Steps

### Create form object

```php

$form = new HtmlForm();

```

### Default config and modifying it

set_config()
Changes the object's default configuration options. Pass an array of arguments you wish to override.
Usage
<?php $form->set_config( $args ); ?>
Default Usage
$args = array (
	'method'	=> 'post',
	'action'	=> $_SERVER['PHP_SELF'] . $q,
	'id'		=> 'hfc',
	'repopulate'	=> true,
	'show_form_tag'	=> true,
	'attr'		=> array()
);
Parameters
$method
(string) (required) method attribute of the form
Default: post
$action
(string) (required) action attribute of the form
Default: $_SERVER['PHP_SELF'] . $q ($q = query string, if applicable)
$id
(string) (optional) the id attribute of the form HTML element
Default: hfc
$repopulate
(boolean) (required) should the form repopulate values upon refresh/submit
Default: true
$show_form_tag
(boolean) (required) should the form tag be displayed
Default: true
$attr
(array) (optional) any other attributes you wish to include in the HTML element. The array consists of 'key' => 'value' pairs.
Default: None

### Adding form elements - add_element()

add_element()
Creates a form element in the form object. Add elements in the order you want them to appear in the rendered form.
Usage
<?php $form->add_element( $args ); ?>
Default Usage
$args = array(
	'type'		=> 'text',
	'name'		=> '',
	'label'		=> '',
	'value'		=> '',
	'required'	=> false,
	'attr'		=> array ( 'class' => '' ),
	'options'	=> array (),
	'prepend'	=> '',
	'append'	=> '',
	'inline_help'	=> ''
);
Parameters
$type
(string) (required) type of form element to create. Options are: text, hidden, textarea, select, radio, file, password, checkbox, and button.
Default: text
$name
(string) (required) name attribute of the form element.
Default: None
$label
(string) (optional) text to display as a label. Use false for no <label> element, e.g. 'label' => false.
Default: None
$value
(string) (optional) default value of the form element.
Default: None
$required
(boolean) (required) whether the form field is required or not. This value determines if the form field must be filled out to pass validation.
Default: false
$attr
(array) (optional) any other attributes you wish to include in the HTML element. The array consists of 'key' => 'value' pairs.
Default: None
$options
(array) (required for select, checkbox, and radio elements) numeric or associative array of options for the form field. If passing a numeric array, the key will be used for both the value and text display of the option. If passing an associative array, the key will be used as the value of the option, while the value of the key will be used as the text display of the option.
Default: None
$prepend
(string) (optional) text to prepend to the form element.
Default: None
$append
(string) (optional) text to append to the form element.
Default: None
$inline_help
(string) (optional) helper text to the form element that is displayed inline after the form element.
Default: None
Returns
Nothing.

### Adding other content - add_content()

add_content()
Adds additional HTML within the flow of the form; for example, adding fieldsets or container elements.
Usage
<?php $form->add_content( $content ); ?>
Parameters
$content
(string) (required) HTML that needs to be added into the flow of the form.
Default: None
Returns
Nothing.
render()
When creating elements and content using add_element() and add_content(), these elements are not rendered immediately. To render the form, use the render method.

### Rendering the form - render()

render()
Adds content in the flow of the form.
Usage
<?php $form->add_content( $content ); ?>
Parameters
$content
(string) (required) HTML that needs to be added into the flow of the form.
Default: None
Returns
Nothing.

### Validating the form - is_valid()

is_valid()
Runs the form through basic validation. Currently, is_valid() only validates required fields. Use this function upon form submission.
Usage
<?php $form->is_valid(); ?>
Returns
If there are errors, an array of found errors if returned. Otherwise, the function returns false.


## Example

```php

$form = new HtmlForm();
$form->set_config( array( 'id' => 'sample' ) );

$form->add_content('<fieldset><legend>Sample Form</legend>');

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
	),
	'required'	=> true
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
	$form->is_valid();
}

$form->add_element( array (
	'type'		=> 'text',
	'name'		=> 'text_element_insert',
	'label'		=> 'Text Element INSERT'
), 5);

?>

```

``` html
<!doctype html>
<html lang="en">
<head>
	<title>Sample</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="styles.css" />
</head>

<body>
	
	<h1>Sample Form</h1>
	<?php $form->render(); ?>
	
</body>
</html>

```