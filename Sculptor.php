<?php

namespace Sculptor;

require "vendor/autoload.php";
require_once 'Element.php';
require_once 'Components.php';
require_once 'Document.php';
require_once 'JS.php';

/**
 * ـ This is the main class of whole Sculptor tools and utilities
 * @author Ali Souri ap.alisouri@gmail.com
 * @package Sculptor
 */
class Sculptor
{
	
	/**
     * ـ Constructor of class
     * @param string $css_source The string name of the considered css source
     * @param string $js_source The string name of the considered js source
     */
	function __construct($css_source = "",$js_source = "")
	{
		$this->css_source = $css_source;
		$this->js_source = $js_source;
	}

	/** @var string Of the name of css source */
	private $css_source = "";

	/** @var string Of the name address of extra components */
	private $extra_css_path = "";

	/** @var string Of the name of js source */
	private $js_source = "";

	/** @var string Of the name of css theme */
	private $css_theme = "";

	/**
     * ـ Getter for css source
     */
	public function getCssSource(){
		return $this->css_source;
	}

	/**
     * ـ Getter for js source
     */
	public function getJSSource(){
		return $this->js_source;
	}

	/**
     * ـ Getter for extra_css_path
     */
	public function getExtraCssPath(){
		return $this->extra_css_path;
	}

	/**
     * ـ Setter for extra_css_path
     */
	public function setExtraCssPath($extra_css_path){
		return $this->extra_css_path = $extra_css_path;
	}

	/**
     * ـ Setter for css_source
     */
	public function setCssSource($css_source){
		return $this->css_source = $css_source;
	}

	/**
     * ـ Setter for theme
     */
	public function setCssTheme($theme){
		$this->css_theme = $theme;
	}

	/**
     * ـ Setter js source
     */
	public function setJsSource($js_source){
		return $this->js_source = $js_source;
	}

	/**
     * ـ This function makes an Element object which represents an html tag
     * @param string $tage_name The name of considered html tag
     * @param string $body_text The text of body for html tag
     * @param array $attributes The name and values of attributes for html tag
     * @return Element The Element object from entered information
     */
	public function makeElement($tage_name,$body_text="",$attributes=[]){
		return new Element($tage_name,$body_text,$attributes);
	}

	/**
     * ـ This function makes an Component object which represents a predefined html component from a css source
     * @param string $component_name The name of considered html component
     * @param array $component_data The information of considered predefined component
     * @return Component The Component object from entered information
     */
	public function makeComponent($component_name,$component_data){
		if ($this->extra_css_path=="") {
			$components = new Component\Components($this->css_source,null);	
		}else{
			$components = new Component\Components($this->css_source,$this->extra_css_path);	
		}
		return $components->makeComponent($component_name,$component_data);
	}

	/**
     * ـ This function makes an Document object which represents a page
     * @return Document The Document object from class information
     */
	public function makeDocument(){
		return new Document($this->css_source,$this->js_source,$this->css_theme);
	}

	/**
     * ـ This function makes an JS object which handles all PHP2JS components
     * @return JS The JS object from class information
     */
	public function makeJSBuilder(){
		return new JS\JS($this->js_source);
	}

}

?>