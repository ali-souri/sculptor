<?php

namespace Sculptor\JS;

require_once 'js/jshandler.php';
require_once 'js/methodhandler.php';
require_once 'js/jsrenderer.php';

/**
 * ـ This is the main class of whole JS tools and utilities
 * @author Ali Souri ap.alisouri@gmail.com
 * @package Sculptor\JS
 */
class JS
{
	
	/**
     * ـ Constructor of class
     * @param string $js_source The string name of the considered js source
     */
	function __construct($js_source)
	{
		$this->js_source=$js_source;
		$this->class_renderer = new JSRenderer($js_source);
	}

	/** @var string Of the name of js_source */
	private $js_source = "pure";

	/** @var array Of the scripts of the current page */
	private $scripts = [];

	/** @var array Of the functions of the current page */
	private $functions = [];

	/** @var array Of the methods of the current page */
	private $methods = [];

	/** @var Element The temporary considered element in the class */
	private $current_temporary_element = "";

	/** @var method The temporary considered method in the class */
	private $current_temporary_method = "";

	/** @var string The temporary considered event_listener_action in the class */
	private $current_temporary_event_listener_action = "";

	/** @var \closure The temporary considered callback function in the class */
	private $current_temporary_event_listener_callback = "";

	/** @var JSRenderer The JSRenderer class considered for whole proccesing in the class */
	private $class_renderer = null;

	/** @var array The code lines which is supposed to be deleted during the rendering */
	public $to_remove_code_lines = [];

	/**
     * ـ This function adds a function closure object to the class
     * @param string $function_name The name of considered function
     * @param closure $function The considered function
     */
	public function defineJsFunction($function_name,$function){
		$this->functions[$function_name] = $function;
		// $this->$function_name = $function;
	}

	/**
     * ـ This function handles all of the invoked dynamic inputs of the class
     * @param Element $current_element The Element to be considered as the current element of class
     * @return JS The current instance of class
     */
	public function __invoke($current_element){
		$this->current_temporary_element = $current_element;
		return $this;
	}

	/**
     * ـ This function handles all of the invoked dynamic methods of the class
     * @param string $method The name of method to be considered as the js method
     * @param array $params The input parameters to be considered as the inputes of js method
     * @return JS The current instance of class
     */
	public function __call($method, $params){
		$default_event_listeners = ["addEventListener","on"];
		$method_array = ['array_id' => rand() ,'method_name'=>$method,'inputs'=>$params , 'target' => $this->current_temporary_element];
		$this->methods[] = $method_array;
		$handler = new MethodHandler($this->js_source,$this->class_renderer,$method_array,$this);
		return $handler->render();
		// if (in_array($method, $default_event_listeners)) {
		//}else{
			// jquery on event handling
		//}
	}

	public function __set($name, $value){
		// echo "<br/>js-start-set<br/>";
		// var_dump($name);
		// echo "<br/>middle<br/>";
		// var_dump($value);
		// echo "<br/>js-end-set<br/>";
		//to be developed
	}

	/**
     * ـ This function renders whole js codes including functions and methods
     * @return string The rendered whole javascript code
     */
	public function render(){
		$rendered_string = " /** JAVASCRIPT GENARATED BY SCULPTOR PHP */ \n  \n// functions \n";
		$rendered_string .= $this->render_functions();
		$rendered_string .= "\n // scripts \n";
		$rendered_string .= $this->render_scripts()."\n";
		return $rendered_string;
	}
	
	/**
     * ـ This function renders functions part of whole js codes
     * @return string The rendered functions part of javascript code
     */
	public function render_functions(){
		$functions_string = "";
		foreach ($this->functions as $function_name => $function) {
			$functions_string .= $this->class_renderer->renderFunction($function_name,$function,$this);
		}
		return $functions_string;
	}

	/**
     * ـ This function renders methods part of whole js codes
     * @return string The rendered methods part of javascript code
     */
	public function render_scripts(){
		$methods_string = "";
		foreach ($this->methods as $key => $method_array) {
			if (count($method_array)>0) {
				$methods_string .= $this->class_renderer->renderMethod($method_array,$this);
			}
		}
		return $methods_string;
	}

	/**
     * ـ This function renders a method of js codes
     * @return string The rendered a method of javascript code
     */
	public function render_script($method_array){
		$methods_string = $this->class_renderer->renderMethod($method_array,$this);
		return $methods_string;
	}

	/**
     * ـ Getter for methods
     */
	public function getMethods(){
		return $this->methods;
	}

	/**
     * ـ Deletes the last considered method of class
     */
	public function deleteLastMethod(){
		$key = count($this->methods)-1;
		if($key>0){
			$this->methods[$key] = [];
		}
	}

}



?>