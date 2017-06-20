<?php

namespace Sculptor\JS;

require_once 'functiondiver.php';

/**
 * ـ The renderer class of whole Sculptor tools and utilities
 * @author Ali Souri ap.alisouri@gmail.com
 * @package Sculptor\JS
 */
class JSRenderer
{

	/**
     * ـ Constructor of class
     * @param string $js_source The string name of the considered js source
     */
	function __construct($js_source)
	{
		$this->js_source=$js_source;
	}

	/** @var string Of the name of js source */
	private $js_source = "";

	/** @var array Of the information of functions */
	private $functions = [];

	/**
     * ـ This function makes a string of the rendered js function
     * @param string $function_name The name of considered function
     * @param \closure $function The closure object function 
     * @param JS $js_object The JS object passed by reference
     * @return string The js rendered function
     */
	public function renderFunction($function_name,$function,$js_object){
		$this->functions[$function_name] = $function;
		$function_string = "function ".$function_name."(";
		if (substr($function_name, 0, 9)=="anonymous") {
			$function_string = "function "."(";
		}
		$function_args = $this->get_func_argNames($this->functions[$function_name]);
		foreach ($function_args as $key => $function_input_name) {
			$function_string .= $function_input_name;
			if ($key+1<count($function_args)) {
				$function_string .= " , ";
			}	
		}
				$function_string .= ") { ";
		if (count($function_args)) {
			$function_diver = new functionDiver($function_args[0]);
			$fn = $this->functions[$function_name];
			$function_result = $fn($function_diver);
			$function_body = $function_diver->renderFunctionBody();
			$function_string .= $function_body;	
		}else{
			$function_string .= "\n";
			$function();
			$after_methods = $js_object->getMethods();
			$code_line = $js_object->render_script(end($after_methods));
			$function_string .= $code_line;
			$js_object->to_remove_code_lines[] = $code_line;
			$js_object->deleteLastMethod();

		}
		$function_string .=  " }" ;

		return $function_string;
	}

	/**
     * ـ This function makes a string of the rendered js method
     * @param array $method_array The information of considered method
     * @param JS $js_object The JS object passed by reference
     * @return string The js rendered method
     */
	public function renderMethod($method_array,$js_object){
		$code = "";
		if (count($method_array)>0) {
			if (($method_array["method_name"]=="addEventListener")||((substr($method_array["method_name"], 2)=="on")&&(strlen($method_array["method_name"]>2)))) {
				$code .= "document.getElementById('".$method_array['target']->get_id()."')";
			}else{
				if (is_string($method_array['target'])) {
					$code .= "$(\"".$method_array['target']."\")";
				}elseif(get_class($method_array['target'])=="Sculptor\Element"){
					$code .= "$(\"#".$method_array['target']->get_id()."\")";
				}elseif(get_class($method_array['target'])=="Sculptor\Component\Component"){
					$code .= "$(\"#".$method_array['target']->get_id()."\")";
				}
			}
			$code .= "." . $method_array['method_name'] . "(";
			if (count($method_array["inputs"])>0) {
				foreach ($method_array["inputs"] as $index => $input) {
					if (is_string($input)) {
						if (array_key_exists($input, $this->functions)) {
							$code .= $input."(";
							$function_args = $this->get_func_argNames($this->functions[$input]);
							foreach ($function_args as $key => $function_input_name) {
								$code .= $function_input_name;
								if ($key+1<count($function_args)) {
									$code .= " , ";
								}else{
									$code .= ") ";
								}
							}
						}else{
							$code .= "\"" . $input . "\"";
						}
						if ($index+1<count($method_array["inputs"])) {
							$code .= ",";
						}
					} elseif (is_callable($input)) {
						 $code .= $this->renderFunction("anonymous_".rand(),$input,$js_object);
						 if ($index+1<count($method_array["inputs"])) {
							$code .= ",";
						 }
					}
				}
			}
			$code .= "); \n";
			return $code;
		}
	}

	/**
     * ـ This function makes an array of the names of inputs of a function
     * @param string $funcName The name of the considered function
     * @return array The names of inputs of the function
     */
	private function get_func_argNames($funcName) {
	    $f = new \ReflectionFunction($funcName);
	    $result = array();
	    foreach ($f->getParameters() as $param) {
	        $result[] = $param->name;   
	    }
	    return $result;
	}

}