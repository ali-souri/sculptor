<?php

namespace Sculptor\JS;

/**
 * ـ This class handles some simple actions on a proccessed js code
 * @author Ali Souri ap.alisouri@gmail.com
 * @package Sculptor\JS
 */
class MethodHandler
{

	/**
     * ـ Constructor of class
     * @param string $js_source The string name of the considered js source
     * @param JSRenderer $class_renderer The renderer object of the JS class
     * @param array $method_array The array of the information of a method
     * @param JS $js_object The JS object passed by reference
     */
	function __construct($js_source,$class_renderer,$method_array,&$js_object)
	{
		$this->js_source =$js_source ;
		$this->class_renderer =$class_renderer ;
		$this->method_array =$method_array ;
		$this->js_object =$js_object ;
	}

		/** @var string Of the name of js source */
		private $js_source = "";

		/** @var JSRenderer For rendering actions */
		private $class_renderer = "";
		
		/** @var array The information of method */
		private $method_array = [];
		
		/** @var JS The JS object passed by reference */
		private $js_object;

		/**
	     * ـ The renderer method of the class which returns a string of js code value
     	 * @return string The js rendered code
	     */
		public function render(){
			$renderer = new JSRenderer($this->js_source);
			return $this->class_renderer->renderMethod($this->method_array,$this->js_object);
		}

}

?>