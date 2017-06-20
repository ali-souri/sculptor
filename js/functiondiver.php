<?php

namespace Sculptor\JS;

/**
 * ـ This class dives into the PHP function to simulate the behavior of it and make a js function line by line
 * @author Ali Souri ap.alisouri@gmail.com
 * @package Sculptor\JS
 */
class functionDiver
{

	/**
     * ـ Constructor of class
     * @param string $variable The starter of the line of codes
     */
	function __construct($variable)
	{
		$this->variable = $variable;
	}

	/** @var string The starter of the line of codes */
	private $variable = "";

	/** @var object The instance of class */
	private $instance = null;

	/** @var array Holdes the information of every line of code */
	private $code_lines = [];

	private $current_property_chain = [];
	private $current_property_value = "";
	private $current_method = "";
	private $current_method_inputs = [];

	/**
     * ـ This function makes a string of the rendered js function body
     * @param bool $minified Determines whether to be minified or not
     * @return string The rendered code of thr body of function
     */
	public function renderFunctionBody($minified=false){
		$code = "";
		$line_seperator = "\n";
		if ($minified) {
			$line_seperator = "";
		}
		foreach ($this->code_lines as $index => $code_line) {
			$code .= $line_seperator;
			$code .= $code_line;
		}
		$code .= $line_seperator;
		return $code;
	}

	/**
     * ـ This function makes the information of a code line
     * @param string $type Determines whether to be property or method
     * @return array The information of the line of the code
     */
	private function makeCodeLine($type){
		if ($type=="property") {
			$code = $this->variable.".";
			foreach ($this->current_property_chain as $index => $property) {
				$code .= $property;
				if ($index+1<count($this->current_property_chain)) {
					$code .= ".";
				}else{
					$code .= "=";
				}
			}
			$value = $this->current_property_value;
			if (is_string($this->current_property_value)) {
				$value = "\"" . $value . "\"";
			}
			$code .= $value . ";";
			$this->current_property_chain = [];
			$this->current_property_value = "";
			$this->code_lines[] = $code;
			return $code;
		} elseif ($type=="method") {
			$code = $this->variable.".";
			foreach ($this->current_property_chain as $index => $property) {
				$code .= $property . ".";
			}
			$code .= $this->current_method . "(" ;
			foreach ($this->current_method_inputs as $index => $input) {
				$code .= $input;
				if ($index+1<count($this->current_method_inputs)) {
					$code .= ",";
				}
			}
			$code .= " ) ";
			$code .= ";";
			$this->current_property_chain = [];
			$this->current_method = "";
			$this->current_method_inputs = [];
			$this->code_lines[] = $code;
			return $code;
		}
	}

	/**
     * ـ The __call function handles every dynamic method executed on the diver
     * @param string $method The name of the dynamic method
     * @param array $params The array of the parameteres assigne to the dynamic method
     * @return $this The current instance of the class
     */
	public function __call($method,$params){
		
		$this->current_method = $method;
		$this->current_method_inputs = $params;

		$this->makeCodeLine("method");

		return $this;
	}

	/**
     * ـ The __get function handles every dynamic property executed on the diver
     * @param string $name The name of the dynamic property
     * @return $this The current instance of the class
     */
	public function __get($name){

		$this->current_property_chain[] = $name;

		return $this;
	}

	/**
     * ـ The __set function handles the last dynamic property executed on the diver and the value which is assigned to it
     * @param string $name The name of the value dynamic property
     * @param * $value The value of the value dynamic property
     * @return $this The current instance of the class
     */
	public function __set($name, $value){

		$this->current_property_chain[] = $name;
		$this->current_property_value = $value;

		$this->makeCodeLine("property");

		return $this;
	}

	public function __invoke($element){
		return $this;
	}

}