# HTML Form

Hate writing and validating HTML forms? Me too. The HTML Form library was designed to make creating, validating, and maintaining forms easier.



## Requirements

1. PHP >= 5.3.2
1. Sessions enabled (if you want the form fields to repopulate)



## Installation

Via Composer:
```json
{
    "require": {
        "jenwachter/html-form": "0.3.*"
    }
}
```



## Documentation

See below for basic usage or [see the wiki](https://github.com/jenwachter/html-form/wiki).



## Basic Usage

```php

// Create the form
$form = new \HtmlForm\Form();

// Add a fieldset
$fieldset = $form->addFieldset("Contact info");

// Add some form fields
$fieldset->addTextbox("name", "Your name", array("required" => true))
	->addEmail("email", "Your email", array("required" => true))
	->addNumber("age", "Your age")
	->addSelect("gender", "Your gender", array("male", "female"));

$form->addSubmit("submit", "Submit");

// Render the form
$form->display();

// Validate the form
if (isset($_POST["submit"]) && $form->isValid()) {
    // continue processing the form as you see fit
}
```



## Changelog

* 0.8
  * Added server-side validation for maxlength attribute
* 0.7
  * Moved location of help text to after label for accessibility
* 0.6.2
  * Added htmlspecialchars method
* 0.6.1
  * Bugfix
* 0.6
  * Added striptags sanitizer
* 0.5
  * Moved validation functions into element classes.
  * Added sanitizer class
* 0.4
  * Removed `$_GET` support
  * Improved unit tests
* 0.3.3
  * Removed label from honeypot
* 0.3.2
  * Removed rendering of global `beforeElement` and `afterElement` content before and after bits of HTML.
* 0.3.1
  * Bug fix
* 0.3
  * Added a flag that allows option form fields to use the numeric keys of the options array as the option field's value. [Issue #13](https://github.com/jenwachter/html-form/issues/13)

* 0.2
  * Method name changes in HtmlForm\Form:
    * render() is now display()
    * compileForm() is now render()
* 0.1
  * Initial release
