# HTML Form

Hate writing and validating HTML forms? Me too. The HTML Form Class was designed to make creating, validating, and maintaining forms easier.


## Requirements

1. PHP >= 5.3.2
1. Sessions enabled (if you want the form fields to repopulate)


## How To


### Create an instance of HtmlForm

#### Usage (showing default params)

Please note: it is NOT necessary to pass an array of configuration to Form(). It is only necessary if you wish to change the default settings.

```php
$config = array(
	"method" => "post",
	"action" => /* current URL */,
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
1. __$action__: (string) Optional. Value of HTML form "action" attribute. _Default: URL of current page plus any existing query string._
1. __$id__: (string) Optional. Value of "id" attribute assigned to the form and used to store post values in a user session. For example, if the ID of the form is "myForm", the post values can be found in <code>$_SESSION["myForm"]</code>. _Default: "hfc"_
1. __$repopulate__: (bool) Optional. Whether the form will repopulate values upon failed submission or page reload. Sessions are required to be enabled. _Default: true_
1. __$attr__: (array) Optional. Associative array of additional attributes (array("attribute" => "value")) that should be included in the `<form>` tag. _Default: array()_
1. __$beforeElement__: (string) Optional. HTML to be displayed before each form element. _Default: ""_
1. __$afterElement__: (string) Optional. HTML to be displayed after each form element. _Default: ""_



### Adding text boxes

#### Usage
```php

// Regular 'ol text box
$form->addTextbox($name, $label, $args);

// Data-specific text boxes (come with validation attached)
$form->addEmail($name, $label, $args)
	 ->addFile($name, $label, $args)
	 ->addNumber($name, $label, $args)
	 ->addRange($name, $label, $min, $max, $args)
	 ->addUrl($name, $label, $args);

// Additional types
$form->addHidden($name, $label, $args)
	 ->addPassword($name, $label, $args);
```


#### Parameters
1. __$name__: (string) Required. Value of the "name" attribute of the form element. Not visible to the user.
1. __$label__: (string) Required. Readable label attached to the form element. Visible to the user.
1. __$min__: (string) Required for Range form element. Minimum number the form element can accept.
1. __$max__: (string) Required for Range form element. Maximum number the form element can accept.
1. __$args__: (array) Optional. Associative array of additional options to pass to the element. Below is default usage:

```php
$args = array(
	"defaultValue" => "",		// Default value of the field
	"requiredSymbol" => "*",	// "required" symbol for this element
	"beforeElement" => "",		// HTML to be displayed before this form element.
	"afterElement" => "",		// HTML to be displayed after this form element.
	"attr" => array(),			// Associative array of additional attributes (array("attribute" => "value"))
								// that should be included in this element's tag
	"required" => false			// Is this form field required to be completed?
);
```



### Adding "option" oriented form fields


#### Usage
```php
$form->addSelect($name, $label, $options, $args)
	 ->addRadio($name, $label, $options, $args)
	 ->addCheckbox($name, $label, $options, $args);
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
	"attr" => array(),			// Associative array of additional attributes (array("attribute" => "value"))
								// that should be included in this element's tag
	"required" => false			// Is this form field required to be completed?
);
```

### Adding buttons

#### Usage
```php

// Submit button
$form->addSubmit($name, $buttonText, $args);

// Generic button
$form->addButton($name, $buttonText, $args);
```

#### Parameters
1. __$name__: (string) Required. Value of the "name" attribute of the text box. Not visible to the user.
1. __$buttonText__: (string) Required. Readable label of the button. Visible to the user.
1. __$args__: (array) Optional. Associative array of additional options to pass to the element. Below is default usage:

```php
$args = array(
	"beforeElement" => "",		// HTML to be displayed before this form element.
	"afterElement" => "",		// HTML to be displayed after this form element.
	"attr" => array()			// Associative array of additional attributes (array("attribute" => "value"))
								// that should be included in this element's tag
);
```


### Adding fieldsets

#### Usage
```php
$fieldset = $form->addFieldset($legend, $args);

// Then add fields to the fieldset
$fieldset->addTextbox($name, $label)
		 ->addTextbox($name, $label);

// Shorthand
$form->addFieldset($legend)
	 ->addTextbox($name, $label)
	 ->addTextbox($name, $label);

// More fields not contained within a fieldset
$form->addTextBox("Favorite Color", "fav_color")
	 ->addSubmit("Submit", "submit");
```


#### Parameters
1. __$ledgend__: (string) Required. Caption for the fieldset.
1. __$attr__: (array) Optional. Associative array of additional attributes (array("attribute" => "value")) that should be included in this element's tag

### <a name="honeypot"></a>Adding a honeypot

[Honeypot](http://haacked.com/archive/2007/09/11/honeypot-captcha.aspx) is a technique to prevent spam bots from submitted data to your form. Bsaically, you add a field to the form that is hidden from the user using CSS. Since the user cannot see it, he/she will not fill it out. However, spam bots will see this form field and fill it out with something. Upon validation, if this form field is filled out, we know we have a bot. See section on [validation](#validation) for how to catch the bot.

#### Usage
```php
$form->addHoneypot($args);
```

#### Parameters
1. __$args__: (array) Optional. Associative array of additional options to pass to the element. Below is default usage:

```php
$args = array(
	"beforeElement" => "",		// HTML to be displayed before this form element.
	"afterElement" => "",		// HTML to be displayed after this form element.
	"attr" => array(),			// Associative array of additional attributes (array("attribute" => "value"))
								// that should be included in this element's tag
);
```


### Rendering the form

Within your HTML document, run the following command:
```php
$form->display();

// or

$code = $form->render();
echo $code;
````


### <a name="validation"></a>Validation

#### Types

##### Datatypes
Datatypes are automatically validated. For example, using <code>addUrl()</code> to add a text box will automatically initiate datatype validation on that field. If input is found to not be a URL, an error will be thrown.

##### Required fields
Any field can be made to be required by passing <code>"required" => true</code> as an element in the <code>$args</code> array:
```php
$form->addTextbox("firstName", "First Name", array(
	"required" => true
));
```

##### Regular expression
Any field can be validated with a regular expression by passing <code>"pattern" => "/YourRegexPattern/"</code> as an element in the <code>$args</code> array:
```php
$form->addTextbox("age", "Age", array(
	"pattern" => "\d{1,3}"
));
```

##### Honeypot
To catch a spot, make sure you have a [honeypot](#honeypot) within your form. Just like the other validation types, honeypots are validated automatically; however the honeypot error is kept in a separate location from the other form errors. If the overall form is passed validation, but the honeypot fails, you can fool the bot into thinking it successfully submitted the form by proceeding with the form submission process, but not store any of the data.


#### Usage

In the logic of your page:
````php
// replace `submit` with the name of your submit button
if (isset($_POST["submit"])) {

	if ($valid = $form->isValid()) {
		// form passed validation; continue with form processing
		// unless you need to check the honeypot...

		if ($honeypot = $form->passedHoneypot()) {
			// form passes honeypot validation
		} else {
			// we have a bot!
		}
	}
}
```
If the form passed validation, `$valid` will evaluate to true and you can continue with your form processing (saving to a database, for example). If the form fails validation, an error box will display with all errors found in the form. If your form is configured to repopulate the form (it is by default), then the user will not have to fill out everything all over again -- just the parts that failed.

If you have a honeypot, you'll need to check that as well before you continue with form processing. `$honeypot` will evaluate to true if it has been confirmed that the user submitting the form is not a bot. If `$honeypot` evaluates to false, you have a bot on your hands. You can either kill the form right then and there, or you can make the bot think it got its data through by continuing with the submission process, but just not submitting the data.


## Changelog

#### v0.2 Noteable Changes/Additions

* HtmlForm\Form
    * render() is now display()
    * compileForm() is now render()
