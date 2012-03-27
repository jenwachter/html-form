<?php


/*-

Still need to...
- build in validation for types of date (dates, numbers, email, etc...)
- add hint option (show someone how to format a field)
- clean up radio/checkbox, select creation

Potential issue:
- having the action URL include the query string could potentially interfere with forms
  submitted by get.
  
  
Requirements:
- sessions enabled


Limitations:
- cannot validate form fields brought in through AJAX


How to:
- upon form submission, $form->isValid();


*/





/** 
 * Class html_form
 * 
 * Provides basic rendering of an HTML form.
 *
 * @author Jen Wachter <jwachter@umaryland.edu>
 * @copyright 2012 Jen Wachter
 */  


class html_form {
	
	// stores form configuration
	public $config = array();
	
	// stores form elements added to the form in sequencial order
	protected $form_elements = array();
	
	// stores validation val_errors
	public $val_errors = array();
		
	// sets default form attributes, contained in $this->config
	public function __construct() {
		
		$q = ( $_SERVER['QUERY_STRING'] ) ? $q = '?' . $_SERVER['QUERY_STRING'] : '';
		
		$this->config = array (
			'id'			=> 'hfc',
			'method'		=> 'post',
			'action'		=> $_SERVER['PHP_SELF'] . $q,
			'attr'			=> array(),
			'repopulate'	=> true
		);
	}
	
	/* update the form's config
	 * @param $a an array of variables that define the form's configuration
	 */
	public function set_config( $a ) {
		$this->config = array_merge($this->config, $a);
	}
	
	
	/* get the form's config
	 * @return $a an array of variables that define the form's configuration
	 */
	public function get_config() {
		return $this->config;
	}
	
	
	// defines HTML to display before the form element
	public function before_element() {
		return '<div class="form_field clearfix">';
	}
	
	// defines HTML to display after the form element
	public function after_element() {
		return '</div>';
	}
	
	
	/* gets the HTML label of a form element
	 * @param $field an array of variables that define the form element
     * @return string the form element's HTML label
     */
	private function get_label( $field ) {
		$required = ( $field['required'] ) ? '*' : '';
		$label = ( $field['label'] ) ? $field['label'] : '';
		return "<label for=\"{$field['name']}\">{$required}{$label}</label>";
	}
	
	
	/* gets the HTML attributes of a form element
     * @param array $a an array of variables that define the form element
     * @return string the form element's attributes
     */
	private function get_attributes( $field ) {
		$attr = array();
		$attr['class'] = '';
		$attr['class'] .= ( $field['required'] ) ? 'required ' : '';
		$attr['class'] .= ( $field['attr']['class'] ) ? $field['attr']['class'] : '';
		
		$attributes = '';
		foreach ( $field['attr'] as $k => $v ) {
		    $attributes .= "{$k}=\"{$v}\" ";
		}
		return $attributes;
	}
	
	
	/* gets the current value attribute of a form element
     * @param array $field an array that defines the form element
     * @return string the form element's current value
     */
	private function get_value( $field ) {
		
		if ( isset( $_SESSION[$this->config['id']][ $field['name'] ] ) ) {
			return $_SESSION[$this->config['id']][ $field['name'] ];
			
		} else if ( isset( $_POST[ $field['name'] ] ) ) {
			return $_POST[ $field['name'] ];
		
		} else {	
			return $field['value'];
		}
	}
	
	
	/* creates an input form element
     * @param array $field an array that defines the form element
     * @return string the input
     */
	private function add_input( $field ) {
		
		$html = '';
		$value = $this->get_value( $field );
		
		
		switch ( $field['type'] ) {
			case 'checkbox':
			case 'radio':
				
				$html .= "<div class=\"{$field['type']}_group\">";
				
				/* check to see if the options are an associative array
				   this will determine how we handle the input value */
				$is_assoc = $this->is_assoc( $field['options'] );
				
				foreach ( $field['options'] as $k => $v ) {
					
					$html .= '<span class="' . $field['type'] . '">';
					
					$html .= '<input type="' . $field['type'] . '" ';
					$html .= $this->get_attributes( $field );
					
					// if a checkbox, make the $_POST key of $field['name'] an array
					if ( $field['type'] == 'checkbox' ) {
						$html .= 'name="' . $field['name'] . '[]" ';
					} else {
						$html .= 'name="' . $field['name'] . '" ';
					}
					
					// handle options in an associative array differently than ones in a numeric array
					if ( $is_assoc ) {
						$html .= 'value="' . $k . '" ';
						if ( $k == $value || ( is_array( $value ) && in_array( $k, $value ) ) )
							$html .= ' checked="checked"';
					
					} else {
						$html .= 'value="' . $v . '" ';
						if ( $v == $value || ( is_array( $value ) && in_array( $v, $value ) ) )
							$html .= ' checked="checked"';
					}
					
					$html .= ' /> ' . $v . '</span>';
				}
				
				$html .= '</div>';
				break;
				
			default:
				$html .= '<input type="' . $field['type'] . '" ';
				$html .= 'name="' . $field['name'] . '" ';
				$html .= $this->get_attributes( $field );
				$html .= 'value="' . $value . '" />';
				break;
				
			/*	
			case 'button':
			case 'checkbox':
			case 'file':
			case 'hidden':
			case 'image':
			case 'password':
			case 'radio':
			case 'reset':
			case 'submit':
			case 'text':	
			*/
			
		}
		return $html;
	}
	
	
	
	/* checks an array to see if it is associative
     * @param array $a an array to check
     * @return boolean
     */
	private function is_assoc( $a ) {
		return (bool) count( array_filter( array_keys( $a ), 'is_string' ) );
	}
	
	
	
	/* creates a textarea form element
     * @param array $field an array that defines the form element
     * @return string the textarea
     */
	private function add_textarea( $field ) {
		$html = '';
		$value = $this->get_value( $field );
		
		$html .= "<textarea name=\"{$field['name']}\" ";
		$html .= "{$this->get_attributes( $field )}>";
		$html .= "{$value}</textarea>";
		return $html;
	}
	
	
	/* creates a select box form element
     * @param array $field an array that defines the form element
     * @return string the select box
     */
	private function add_select( $field ) {
		
		/* check to see if the options are an associative array
		   this will determine how we handle the input value */
		$is_assoc = $this->is_assoc( $field['options'] );
		
		$html = '';
		$value = $this->get_value( $field );
		
		$html .= "<select ";
		$html .= "name=\"{$field['name']}\" ";
		$html .= "{$this->get_attributes( $field )}>";
		
		
		// handle options in an associative array differently than ones in a numeric array
		if ( $is_assoc ) {
			
			foreach ( $field['options'] as $k => $v ) {
				$html .= "<option value=\"{$k}\"";
				if ( $value == $k) {
					$html .= " selected=\"selected\"";
				}
				$html .= ">{$v}</option>";
			}
		
		} else {
		
			foreach ( $field['options'] as $k => $v ) {
				$html .= "<option value=\"{$v}\"";
				if ( $value == $v) {
					$html .= " selected=\"selected\"";
				}
				$html .= ">{$v}</option>";
			}
		}
		
		$html .= "</select>";
		return $html;
	}
	
	
	/* defines the form element to be created and adds it to the $form_elements array
     * @param array $field an array that defines the form element
     * @return void
     */
	public function add_element( $field = array() ) {
	
		// create defaults for all possibilities
		$defaults = array(
			'before_element'	=> '',
			'after_element'	=> '',
			'type'			=> 'text', // text, hidden, textarea, select, radio, file, password, checkbox, button
			'name'			=> '',
			'label'			=> '',
			'value'			=> '',
			'show_label'	=> true,
			'required'		=> false,
			'attr'			=> array ( 'class' => '' ),
			'options'		=> array ()
		);
		
		// merge with the actual values sent to the function
		$field = array_merge($defaults, $field);
		$field['attr'] = array_merge($defaults['attr'], $field['attr']);
		$field['options'] = array_merge($defaults['options'], $field['options']);
		
		$this->form_elements[$field['name']] = array(
			'field'	=> $field,
			'html'	=> ''
		);
	}
	
	
	/* adds content other than form elements to the form
     * @param string $content a string of html
     * @return void
     */
	public function add_content( $content ) {
		$this->form_elements[]['html'] = $content;
	}
	
	
	/* checks basic validity of the form and enables repopulating
     * @return array of fields with errors
     */
	public function isValid() {
		
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
			$data = $_POST;
		} else {
			$data = $_GET;
		}
		
		if ( $this->config['repopulate'] ) {
			foreach ( $data as $k => $v ) {
				$_SESSION[$this->config['id']][$k] = $v;
			}
		}
		
		
		// empty array
		$this->val_errors = array();
		
		foreach ( $this->form_elements as $k => $v ) {
			
			if ( isset( $v['field'] ) ) {
				
				// validate required fields
				if ( $v['field']['required'] ) {
					
					if ( ! strlen( trim( $_POST[ $v['field']['name'] ] ) ) ) {
						$this->val_errors[] = '"' . $v['field']['label'] . '" is a required field.';
					}
				}
			}
		}
		
		return $this->val_errors;
	}
	
	
	
	/* renders the entire HTML form
     * @return void
     */
	public function render() {
		
		// see if there is a file field. if so, change the entype
		foreach ( $this->form_elements as $k => $v ) {
			
			if ( isset( $v['field']['type'] ) && $v['field']['type'] == 'file' ) {
				$this->config['attr']['enctype'] = 'multipart/form-data';
				break;
			}
		}
		
		// get the form attributes
		$attributes = '';
		foreach ( $this->config['attr'] as $k => $v ) {
		    $attributes .= "{$k}=\"{$v}\" ";
		}
		
		
		if ( isset( $this->val_errors ) && !empty( $this->val_errors ) ) {
			
			$count = count($this->val_errors);
			$message = ( $count > 1 ) ? 'The following ' . $count . ' errors were found:' : 'The following error was found:';
			
			echo '<div class="hfc-error ' . $this->config['id'] . '">';
			echo '<p class="message">' . $message . '</p>';
			echo '<ul>';
			
			foreach ( $this->val_errors as $k => $v ) {
				echo '<li>' . $v . '</li>';
			}
			
			echo '</ul>';
			echo '</div>';
			
		}
		
		echo "<form method=\"{$this->config['method']}\" action=\"{$this->config['action']}\" id=\"{$this->config['id']}\" {$attributes}>";
		
		// render each form element
		foreach ( $this->form_elements as $k => $v ) {
			
			// for add_content elements
			if ( isset( $v['html'] ) ) {
				echo $v['html'];
			}
			
			// for add_element elements
			if ( isset( $v['field'] ) ) {
				
				$html = '';
				
				if ( $v['field']['type'] != 'hidden' )
					$html .= $this->before_element();
				
				
				if ( $v['field']['show_label'] && $v['field']['type'] != 'hidden' )
					$html .= $this->get_label( $v['field'] );
				
				if ( $v['field']['before_element'] ) {
					$html .= '<span class="before">';
					$html .= $v['field']['before_element'];
				}
				
				switch( $v['field']['type'] ) {
					case 'textarea':
						$html .= $this->add_textarea( $v['field'] );
						break;
					case 'select':
						$html .= $this->add_select( $v['field'] );		
						break;
					case 'button':
					case 'checkbox':
					case 'file':
					case 'hidden':
					case 'image':
					case 'password':
					case 'radio':
					case 'reset':
					case 'submit':
					case 'text':
						$html .= $this->add_input( $v['field'] );
						break;
				}
				
				if ( $v['field']['after_element'] ) {
					$html .= $v['field']['after_element'];
					$html .= '</span>';
				}
				
				if ( $v['field']['type'] != 'hidden' )
					$html .= $this->after_element();
				
				echo $html;
				
				
			}
			
		}
		echo "</form>";
	}
	
}

?>