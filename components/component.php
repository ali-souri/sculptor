<?php

namespace Sculptor\Component;

/**
 * ـ The Component class which represents every html component inthe system
 * @author Ali Souri ap.alisouri@gmail.com
 * @package Sculptor\Component
 */
class Component
{
	
	/**
     * ـ Constructor of class
     * @param string $component_name The string name of the considered component
     * @param array $component_data The array of the considered component information entered by the user
     * @param string $component_template The string value of the corresponding template to be rendered and it's supposed to be on twig
     */
	function __construct($component_name,$component_data,$component_template)
	{
		$this->component_name=$component_name;
		$this->component_data=$component_data;
		$this->component_template=$component_template;
		if (array_key_exists("id", $component_data)) {
			$this->id = $component_data['id'];
		}else{
			$id = "sculptor-".$component_name."-".rand();
			$this->id = $id;
			$this->component_data['id'] = $id;
		}
	}

	/** @var string Of the id of component */
	private $id = "";
	
	/** @var string Of name of the component */
	private $component_name = "";

	/** @var array Of the information of component */
	private $component_data = [];

	/** @var string Of the twig template of the component */
	private $component_template = "";

	/**
     * ـ Getter for id
     */
	public function get_id(){
		return $this->id;
	}

	/**
     * ـ Getter for component_name
     */
	public function get_component_name(){
		return $this->component_name;
	}

	/**
     * ـ Getter for component_data
     */
	public function get_component_data(){
		return $this->component_data;
	}

	/**
     * ـ Getter for component_template
     */
	public function get_component_template(){
		return $this->component_template;
	}

	/**
     * ـ Setter for id
     */
	public function set_id($id){
		return $this->id = $id;
	}

	/**
     * ـ Setter for component_name
     */
	public function set_component_name($component_name){
		return $this->component_name=$component_name;
	}

	/**
     * ـ Setter for component_data
     */
	public function set_component_data($component_data){
		return $this->component_data=$component_data;
	}

	/**
     * ـ Setter for component_template
     */
	public function set_component_template($component_template){
		return $this->component_template=$component_template;
	}

	/**
     * ـ This function renders the html code of the object
     * @return string The string of the html of the component
     */
	public function render(){
		$twig = new \Twig_Environment(new \Twig_Loader_String());
		$rendered = $twig->render(
		  $this->component_template,
		  $this->component_data
		);
		return $rendered;
	}

}

?>