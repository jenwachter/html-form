<!doctype html>
<html lang="en">
<head>
	<title>HTML Form Class | Docuemntation</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="styles.css" />
</head>


<body>
	
	<h1>HTML Form Class</h1>
	<p>The HTML Form Class was designed to make creating, validating, and maintaining multiple forms easier. Still a work-in-progress, some features are slim (is_valid method).</p>
	<p>The one requirement of the HTML Form Class is sessions must be enabled.</p>
	
	<div class="section">
		<h2>Steps</h2>
		<ol>
			<li><a href="#create_object">Create form object - <code>new html_form;</code></a></li>
			<li><a href="#config">Default config and modifying it - <code>set_config()</code></a></li>
			<li><a href="#add_element">Adding form elements - <code>add_element()</code></a></li>
			<li><a href="#add_content">Adding other content - <code>add_content()</code></a></li>
			<li><a href="#render">Rendering the form - <code>render()</code></a></li>
			<li><a href="#is_valid">Validating the form - <code>is_valid()</code></a></li>
			<li><a href="sample.php">Sample</a> and <a href="sample_code.php">Sample code</a></li>
		</ol>
	</div>
	
	
	<div class="section">
		<h2><a name="create_object">new html_form</h2>
		<p>In order to use the HTML Form class, you must include the include the class in your script and create an instance of the class. A new instance must be created for each form, but the class only needs to be included once.</p>
		
<pre>require_once 'class_html_form.php';
$form = new html_form;</pre>
	</div>
	
	
	<div class="section">
		<h2><a name="config">set_config()</h2>
		<p>Changes the object's default configuration options. Pass an array of arguments you wish to override.</p>
		
		<h3>Usage</h3>
		<pre><?php echo htmlspecialchars( '<?php $form->set_config( $args ); ?>' ); ?></pre>
		
		<h3>Default Usage</h3>
		
<pre>$args = array (
	'method'	=> 'post',
	'action'	=> $_SERVER['PHP_SELF'] . $q,
	'id'		=> 'hfc',
	'repopulate'	=> true,
	'show_form_tag'	=> true,
	'attr'		=> array()
);</pre>
		
		<h3>Parameters</h3>
		
		<dl>
			<dt>$method</dt>
			<dd>(string) (required) method attribute of the form</dd>
			<dd class="small">Default: post</dd>
			
			<dt>$action</dt>
			<dd>(string) (required) action attribute of the form</dd>
			<dd class="small">Default: $_SERVER['PHP_SELF'] . $q ($q = query string, if applicable)</dd>
			
			<dt>$id</dt>
			<dd>(string) (optional) the id attribute of the form HTML element</dd>
			<dd class="small">Default: hfc</dd>
			
			<dt>$repopulate</dt>
			<dd>(boolean) (required) should the form repopulate values upon refresh/submit</dd>
			<dd class="small">Default: true</dd>
			
			<dt>$show_form_tag</dt>
			<dd>(boolean) (required) should the form tag be displayed</dd>
			<dd class="small">Default: true</dd>
			
			<dt>$attr</dt>
			<dd>(array) (optional) any other attributes you wish to include in the HTML element. The array consists of 'key' => 'value' pairs.</dd>
			<dd class="small">Default: <em>None</em></dd>
		</dl>
	</div>
	
	
	<div class="section">
		<h2><a name="add_element">add_element()</h2>
		<p>Creates a form element in the form object. Add elements in the order you want them to appear in the rendered form.</p>
		
		<h3>Usage</h4>
		<pre><?php echo htmlspecialchars( '<?php $form->add_element( $args ); ?>' ); ?></pre>
		
		<h3>Default Usage</h4>
		
<pre>$args = array(
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
);</pre>
		
		<h3>Parameters</h4>
		
		<dl>
			<dt>$type</dt>
			<dd>(string) (required) type of form element to create. Options are: text, hidden, textarea, select, radio, file, password, checkbox, and button.</dd>
			<dd class="small">Default: text</dd>
		</dl>
		
		<dl>
			<dt>$name</dt>
			<dd>(string) (required) name attribute of the form element.</dd>
			<dd class="small">Default: <em>None</em></dd>
		</dl>
		
		<dl>
			<dt>$label</dt>
			<dd>(string) (optional) text to display as a label. Use <strong>false</strong> for no <code><?php echo htmlspecialchars( '<label>' ); ?></code> element, e.g. <code>'label' => false</code>.</dd>
			<dd class="small">Default: <em>None</em></dd>
		</dl>
		
		<dl>
			<dt>$value</dt>
			<dd>(string) (optional) default value of the form element.</dd>
			<dd class="small">Default: <em>None</em></dd>
		</dl>
		
		<dl>
			<dt>$required</dt>
			<dd>(boolean) (required) whether the form field is required or not. This value determines if the form field must be filled out to pass validation.</dd>
			<dd class="small">Default: false</dd>
		</dl>
		
		<dl>
			<dt>$attr</dt>
			<dd>(array) (optional) any other attributes you wish to include in the HTML element. The array consists of 'key' => 'value' pairs.</dd>
			<dd class="small">Default: <em>None</em></dd>
		</dl>
		
		<dl>
			<dt>$attr</dt>
			<dd>(array) (required for <em>select</em>, <em>checkbox</em>, and <em>radio</em> elements) numeric or associative array of options for the form field. If passing a numeric array, the key will be used for both the value and text display of the option. If passing an associative array, the key will be used as the value of the option, while the value of the key will be used as the text display of the option.</dd>
			<dd class="small">Default: <em>None</em></dd>
		</dl>
		
		<dl>
			<dt>$prepend</dt>
			<dd>(string) (optional) text to prepend to the form element.</dd>
			<dd class="small">Default: <em>None</em></dd>
		</dl>
		
		<dl>
			<dt>$append</dt>
			<dd>(string) (optional) text to append to the form element.</dd>
			<dd class="small">Default: <em>None</em></dd>
		</dl>
		
		<dl>
			<dt>$inline_help</dt>
			<dd>(string) (optional) helper text to the form element that is displayed inline after the form element.</dd>
			<dd class="small">Default: <em>None</em></dd>
		</dl>
		
		<h3>Returns</h4>
		<p>Nothing.</p>
	</div>
	
	
	<div class="section">
		<h2><a name="add_content">add_content()</h2>
		Adds additional HTML within the flow of the form; for example, adding fieldsets or container elements.</p>
		
		<h3>Usage</h4>
		<pre><?php echo htmlspecialchars( '<?php $form->add_content( $content ); ?>' ); ?></pre>
		
		<h3>Parameters</h4>
		
		<dl>
			<dt>$content</dt>
			<dd>(string) (required) HTML that needs to be added into the flow of the form.</dd>
			<dd class="small">Default: <em>None</em></dd>
		</dl>
		
		<h3>Returns</h4>
		<p>Nothing.</p>
	</div>
	
	
	<div class="section">
		<h2><a name="render">render()</h2>
		<p>When creating elements and content using <code>add_element()</code> and <code>add_content()</code>, these elements are not rendered immediately. To render the form, use the <code>render</code> method.</p>
		
		<h3>render()</h3>
		<p>Adds content in the flow of the form.</p>
		
		<h3>Usage</h4>
		<pre><?php echo htmlspecialchars( '<?php $form->add_content( $content ); ?>' ); ?></pre>
		
		<h3>Parameters</h4>
		
		<dl>
			<dt>$content</dt>
			<dd>(string) (required) HTML that needs to be added into the flow of the form.</dd>
			<dd class="small">Default: <em>None</em></dd>
		</dl>
		
		<h3>Returns</h4>
		<p>Nothing.</p>
	</div>
	
	
	<div class="section">
		<h2><a name="is_valid">is_valid()</h2>
		<p>Runs the form through basic validation. Currently, <code>is_valid()</code> only validates required fields. Use this function upon form submission.</p>
		
		<h3>Usage</h4>
		<pre><?php echo htmlspecialchars( '<?php $form->is_valid(); ?>' ); ?></pre>
		
		<h3>Returns</h4>
		<p>If there are errors, an array of found errors if returned. Otherwise, the function returns false.</p>
	</div>
	
	
	<p>&copy 2012 Jen Wachter</p>
	
</body>
</html>