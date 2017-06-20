<?php

namespace Sculptor;

/**
 * ـ This is the main class of definition of a html element in the system
 * @author Ali Souri ap.alisouri@gmail.com
 * @package Sculptor
 */
class Element
{
	
	/**
     * ـ Constructor of class
     * @param string $tag_name The string name of the considered tag
     * @param string $body_text The string name of the considered body text of tag
     * @param array $attributes The array of the names and valuse of attributes of an element
     */
	function __construct($tag_name,$body_text="",$attributes=[])
	{
		$this->tag_name = $tag_name;
		$this->body_text = $body_text;
		$this->attributes = $attributes;
		if (array_key_exists("id", $attributes)) {
			$this->id = $attributes['id'];
		}else{
			$id = "sculptor-".rand();
			$this->id = $id;
			$this->attributes['id'] = $id;
		}
	}

	/** @var string Of the id of element */
	private $id = "";

	/** @var string Of the name of element */
	private $tag_name = "";
	
	/** @var string Of the text body of element */
	private $body_text = "";

	/** @var array Of the attributes of element */
	private $attributes = [];

	/**
     * ـ Getter for id
     */
	public function get_id(){
		return $this->id;
	}

	/**
     * ـ Getter for tag_name
     */
	public function get_tag_name(){
		return $this->tag_name;
	}

	/**
     * ـ Getter for body_text
     */
	public function get_body_text(){
		return $this->body_text;
	}

	/**
     * ـ Getter for attributes
     */
	public function get_attributes(){
		return $this->attributes;
	}

	/**
     * ـ Setter for id
     */
	public function set_id($id){
		return $this->id = $id;
	}

	/**
     * ـ Setter for tag_name
     */
	public function set_tag_name($tag_name){
		return $this->tag_name = $tag_name;
	}

	/**
     * ـ Setter for body_text
     */
	public function set_body_text($body_text){
		return $this->body_text = $body_text;
	}

	/**
     * ـ Setter for attributes
     */
	public function set_attributes($attributes){
		return $this->attributes = $attributes;
	}

	/**
     * ـ Adder to attributes
     */
	public function addAttributes($attributes){
		foreach ($attributes as $attribute_name => $attribute_value) {
			$this->attributes[$attribute_name] = $attribute_value;
		}
	}

	/**
     * ـ This function makes the whole html of the element
     * @return string Rendered Html of the element
     */
	public function render(){
		$tag_string = "<";
		$tag_string.=$this->tag_name." ";
		if (!array_key_exists("id", $this->attributes)) {
				$this->attributes['id'] = $this->id;
			}
		if (count($this->attributes)>0) {
			foreach ($this->attributes as $name => $value) {
				$tag_string.=$name."=\"".$value."\" ";
			}	
		}
		$tag_string .= ">".$this->body_text." <!-- tag-body --> "."</".$this->tag_name.">";
		return $tag_string;
	}

}

?>