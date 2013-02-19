# HTML Form

Hate writing and validating HTML forms? Me too. The HTML Form Class was designed to make creating, validating, and maintaining forms easier.


## Requirements

1. PHP >= 5.3.2
1. Sessions enabled (if you want the form fields to repopulate)


## How To


### Create an instance of HtmlForm

#### Usage (showing default params)

Please note: it is NOT necessary to pass an array of configuration to Form(). It is only necessary if you with to change the default.

```php
$config = array(
	"method" => "post",
	"action" => {current URL},
	"id" => "hfc",
	"repopulate" => true,
	"attr" => array(),
	"beforeElement" => "",
	"afterElement" => ""
);

$form = new \HtmlForm\Form($config);
```

#### Parameters

1. __$method__: (string) Optional. Value of HTML form "method" attribute. _Default: "post"_
1. __$action__: (string) Optional. Value of HTML form "action" attribute. _Default: current URL plus any existing query string._
1. __$id__: (string) Optional. Identifier assigned to the form. Used to store post values in a user session. For example, if the ID of the form is "myForm", the post values can be found in <code>$_SESSION["myForm"]</code>. _Default: "hfc"_
1. __$repopulate__: (bool) Optional. Whether the form will repopulate values upon failed submission or page reload. _Default: true_
1. __$attr__: (array) Optional. Associative array of additional attributes ("attribute" => "value") that should be included in the <form> tag. _Default: array()_
1. __$beforeElement__: (string) Optional. HTML to be displayed before each form element. _Default: ""_
1. __$afterElement__: (string) Optional. HTML to be displayed after each form element. _Default: ""_



### Adding text boxes

#### Usage
```php

// Regular 'ol text box
$form->addTextbox($name, $label, $args);

// Data-specific text boxes
$form->addEmail($name, $label, $args);
$form->addFile($name, $label, $args);
$form->addNumber($name, $label, $args);
$form->addRange($name, $label, $min, $max, $args);
$form->addUrl($name, $label, $args);

// Additional types
$form->addHidden($name, $label, $args);
$form->addPassword($name, $label, $args);
```


#### Parameters
1. __$name__: (string) Required. Value of the "name" attribute of the form element. Not visible to the user.
1. __$label__: (string) Required. Readable label attached to the form element. Visible to the user.
1. __$min__: (string) Required for Range form element. Minimum number the form element can accept.
1. __$max__: (string) Required for Range form element. Maximum number the form element can accept.
1. __$args__: (array) Optional. Associative array of additional options to pass to the element. Below is default usage:

```php
$args = array(
	"requiredSymbol" => "*",	// "required" symbol for this element
	"beforeElement" => "",		// HTML to be displayed before this form element.
	"afterElement" => "",		// HTML to be displayed after this form element.
	"attr" => array(),			// Associative array of additional attributes ("attribute" => "value")
								// that should be included in this element's tag
	"required" => false			// Is this form field required to be completed?
);
```



### Adding "option" oriented form fields


#### Usage
```php
$form->addSelect($name, $label, $options, $args);
$form->addRadio($name, $label, $options, $args);
$form->addCheckbox($name, $label, $options, $args);
```

#### Parameters
1. __$name__: (string) Required. Value of the "name" attribute of the form element. Not visible to the user.
1. __$label__: (string) Required. Readable label attached to the form element. Visible to the user.
1. __$options__: (array) Required. Numeric or associative array of options. If an associative array is given, the key is used as the option's "value" attribute and the value is used as the visible option to the user. If a numeric array is given, the value is used for both elements in the form field.
1. __$args__: (array) Optional. Associative array of additional options to pass to the element. Below is default usage:

```php
$args = array(
	"requiredSymbol" => "*",	// "required" symbol for this element
	"beforeElement" => "",		// HTML to be displayed before this form element.
	"afterElement" => "",		// HTML to be displayed after this form element.
	"attr" => array(),			// Associative array of additional attributes ("attribute" => "value")
								// that should be included in this element's tag
	"required" => false			// Is this form field required to be completed?
);
```

### Adding Buttons

Primarily used for submit buttons, this method can be used to add any kind of button.

#### Usage
```php
$form->addButton($name, $buttonText, $args);
```

#### Parameters
1. __$name__: (string) Required. Value of the "name" attribute of the text box. Not visible to the user.
1. __$buttonText__: (string) Required. Readable label of the form element. Visible to the user.
1. __$args__: (array) Optional. Associative array of additional options to pass to the element. Below is default usage:

```php
$args = array(
	"requiredSymbol" => "*",	// "required" symbol for this element
	"beforeElement" => "",		// HTML to be displayed before this form element.
	"afterElement" => "",		// HTML to be displayed after this form element.
	"attr" => array(),			// Associative array of additional attributes ("attribute" => "value")
								// that should be included in this element's tag
	"required" => false			// Is this form field required to be completed?
);
```


#### Render the form

Within your HTML document, run the following command:
```php
$form->render();
````


### Validation

#### Types

##### Datatypes
Datatypes are automatically validated. For example, using <code>addUrl()</code> to add a text box will automatically initiate datatype validation on that field. If input is found to not be a URL, an error will be thrown.

##### Required fields
Any field can be made to be required by passing <code>"required" => true</code> as an element in the <code>$args</code> array:
```php
$form->addTextbox("firstName", "First Name", array(
	"required" => true
));


#### Usage

In the logic of your page:
````php
// make sure "submit" is the name of your submit button
if (isset( $_POST["submit"])) {
	$valid = $form->isValid();
}
```
If the form passed validation, $valid will evaluate to true and you can continue with your form processing. If the form fails validation, an error box will display with all errors found in the form. If your form is configured to repopulate the form (it is by default), then the user will not have to fill out everything all over again -- just the parts that failed.



