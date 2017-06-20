<?php

namespace Sculptor;

/**
 * ـ This is the general class of handling every aspect of page
 * @author Ali Souri ap.alisouri@gmail.com
 * @package Sculptor
 */
class Document
{
	
	/**
     * ـ Constructor of class
     * @param string $css_source The string name of the considered css source
     * @param string $js_source The string name of the considered js source
     * @param string $css_theme The string name of the considered css theme
     */
	function __construct($css_source,$js_source,$css_theme)
	{
		$this->css_source = $css_source;
		$this->js_source = $js_source;
		$this->css_theme = $css_theme;
	}


	/** @var Element For the temporary actions in the class  */
	private $temporary_element = "";

	/** @var array Of the main elements and components of the page  */
	private $primary_elements_array = [];

	/** @var array Of the secondary elements and components of the page  */
	private $secondary_elements_array = [];

	/** @var array Of the corrected elements and components of the page  */
	private $temporary_corrected_array = [];

	/** @var string Of the title of the page  */
	private $title = "Sculptor Page";
	
	/** @var string[] Of the meta tags of the page  */
	private $meta_tags = [];

	/** @var string Of the name of css source */
	private $css_source = "";

	/** @var string Of the name of js source */
	private $js_source = "";

	/** @var string Of the name of css theme */
	private $css_theme = "";

	/** @var array Of the addresses of the styles prepared by system  */
	private $system_styles = [];

	/** @var array Of the addresses of the scripts prepared by system  */
	private $system_scripts = [];

	/** @var array Of the addresses of the scripts prepared by user  */
	private $user_style_urls = [];

	/** @var array Of the styles prepared by user  */
	private $user_styles = [];

	/** @var array Of the addresses of the scripts prepared by user  */
	private $user_script_urls = [];

	/** @var array Of the scripts prepared by system  */
	private $user_scripts = [];

	/**
     * ـ Setter for title
     */
	public function setTitle($title){
		$this->title = $title;
	}

	/**
     * ـ Adder to meta_tag
     */
	public function addMetaTag($meta_tag){
		$this->meta_tags[] = $meta_tag;
	}

	/**
     * ـ Adder to user_style_urls
     */
	public function addStyleURL($url){
		$this->user_style_urls[] = $url;
	}

	/**
     * ـ Adder to user_script_urls
     */
	public function addScriptURL($url){
		$this->user_script_urls[] = $url;
	}

	/**
     * ـ Adder to user_styles
     */
	public function addStyle($style){
		$this->user_styles[] = $style;
	}

	/**
     * ـ Adder to user_scripts
     */
	public function addScript($script){
		$this->user_scripts[] = $script;
	}

	/**
     * ـ This function adds an element to the primary_elements_array 
     * @param Element $element The element to add to the primary_elements_array
     * @param bool $recursive To determine whether to be in recursive mode or not
     */
	public function add($element,$recursive=false){
		if (!$recursive) {
			$this->primary_elements_array["body"][] = $element;	
		}
		foreach ($this->secondary_elements_array as $father_id => $child_elements) {
			
			if ($father_id==$element->get_id()) {
				$this->primary_elements_array[$element->get_id()]=$child_elements;
				foreach ($child_elements as $ch_element) {
					$this->add($ch_element,true);
				}
				unset($this->secondary_elements_array[$father_id]);
			}elseif($father_id=="#") {
				foreach ($child_elements as $key => $child_element) {
					if($child_element->get_id()==$element->get_id()) {
						// $this->add($child_element,true);
					    unset($this->secondary_elements_array['#'][$key]);
					}
				}
			}
		}
		// foreach ($this->secondary_elements_array as $father_id => $child_elements) {
		// 	if ($father_id=="#"){
		// 		foreach ($child_elements as $key => $child_element) {
		// 			if($child_element->get_id()==$element->get_id()) {
		// 				$this->add($ch_element,true);
		// 			    unset($this->secondary_elements_array['#'][$key]);
		// 			}
		// 		}
		// 	}
		// }
	}

	/**
     * ـ This function puts the temporary_element element in the target_element
     * @param Element $target_element The element to get put by the target_element
     */
	public function putIn($target_element){
		if ($this->element_exists("primary",$target_element)) {
			$this->primary_elements_array[$target_element->get_id()] = [];
			$this->primary_elements_array[$target_element->get_id()][] = $this->temporary_element;
		}elseif ($this->element_exists("secondary",$target_element)) {
			$this->secondary_elements_array[$target_element->get_id()] = [];
			$this->secondary_elements_array[$target_element->get_id()][] = $this->temporary_element;
		}else{
			$this->secondary_elements_array["#"][] = $target_element;
			$this->secondary_elements_array[$target_element->get_id()][] = $this->temporary_element;
		}
	}

	/**
     * ـ This function adds the temporary_element element in the target_element
     * @param Element $target_element The element to get added by the target_element
     */
	public function addIn($target_element){
		if ($this->element_exists("primary",$target_element)) {
			$this->primary_elements_array[$target_element->get_id()][] = $this->temporary_element;
		}elseif ($this->element_exists("secondary",$target_element)) {
			$this->secondary_elements_array[$target_element->get_id()][] = $this->temporary_element;
		}else{
			$this->secondary_elements_array["#"][] = $target_element;
			$this->secondary_elements_array[$target_element->get_id()][] = $this->temporary_element;
		}
	}

	/**
     * ـ This function puts the temporary_element element in the target_element
     * @param string $target The string which determines the proccess is supposed to be on the primary or secondary elements array
     * @param Element $element The father element which is used to check
     * @return bool Which determines the element exist or not
     */
	private function element_exists($target,$element){
		if ($target=="primary") {
			foreach ($this->primary_elements_array as $father_id => $stored_elements_array) {
				foreach ($stored_elements_array as $stored_element) {
					if (($father_id==$element->get_id())||($stored_element->get_id()==$element->get_id())) {
						return true;
					}	
				}
			}
		}elseif ($target=="secondary") {
			foreach ($this->secondary_elements_array as $father_id => $stored_elements_array) {
				foreach ($stored_elements_array as $stored_element) {
					if (($father_id==$element->get_id())||($stored_element->get_id()==$element->get_id())) {
						return true;
					}
				}
			}
		}
		return false;
	}

	/**
     * ـ This function makes the whole html of page
     * @return string Rendered Html of the page
     */
	public function render(){

		$html = "<!DOCTYPE html>\n<html>\n";

		$html .= $this->render_head();

		$html .= $this->render_body();

		$html .= "</html>";

		return $html;

	}

	/**
     * ـ This function makes the whole head part of the html of page
     * @return string Rendered head of Html of the page
     */
	public function render_head(){
		$head_string = "<head>\n";
		$head_string .= "<title>".$this->title."</title>\n";
		if (count($this->meta_tags)>0) {
			foreach ($this->meta_tags as $index => $meta_tag) {
				$head_string .= $meta_tag;
			}	
		}
		if ($this->css_source=="bootstrap") {
			if ($this->css_theme!="") {
				$head_string .= "<link rel=\"stylesheet\" href=\"http://bootswatch.com/".$this->css_theme."/bootstrap.min.css\" />\n";
			}else{
				$head_string .= "<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" />\n";
			}
		}elseif ($this->css_source=="jquery"){
			if ($this->css_theme!="") {
				$head_string .= "<link rel=\"stylesheet\" href=\"https://code.jquery.com/ui/1.12.1/themes/".$this->css_theme."/jquery-ui.css\" />\n";
			}else{
				$head_string .= "<link rel=\"stylesheet\" href=\"https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css\" />\n";
			}
		}
		if (count($this->user_style_urls)>0) {
			foreach ($this->user_style_urls as $index => $url) {
				$head_string .= "<link rel=\"stylesheet\" href=\"".$url."\" />\n";
			}
		}
		if (count($this->user_styles)>0) {
			foreach ($this->user_styles as $index => $style) {
				$head_string .= "<style>\n".$style."\n</style>\n";
			}
		}
		if ($this->js_source=="bootstrap") {
			$head_string .= "<script type=\"text/javascript\" src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\" ></script>\n";
		}elseif ($this->js_source=="jquery"){
			$head_string .= "<script type=\"text/javascript\" src=\"https://code.jquery.com/jquery-3.2.1.min.js\" ></script>\n";
			if ($this->css_source=="jquery") {
				$head_string .= "<script type=\"text/javascript\" src=\"https://code.jquery.com/ui/1.12.0/jquery-ui.min.js\" ></script>\n";
			}
		}
		if (count($this->user_script_urls)>0) {
			foreach ($this->user_script_urls as $index => $script) {
				$head_string .= "<script type=\"text/javascript\" src=\"".$script."\" />\n";
			}
		}
		$head_string .= "</head>";
		return $head_string;
	}

	/**
     * ـ This function makes the whole body part of the html of page
     * @return string Rendered body of Html of the page
     */
	public function render_body(){

		$this->temporary_corrected_array = [];

		$this->CorrectElementsArray($this->primary_elements_array);

		$xml_object = new \SimpleXMLElement('<body/>');

		$this->sculptor_array2xml($xml_object,$this->temporary_corrected_array);

		$this->addUserScripts($xml_object);

		$xml_string = $xml_object->asXML();

		$xml_string = $this->erase_extra_tags($xml_string);

		return $xml_string;

	}

	/**
     * ـ This function adds all of the scripts entered by user to the entered xml_object
     * @param \SimpleXMLElement $xml_object The xml_object of the body part of the page
     */
	private function addUserScripts($xml_object){
		$scripts_string = "";
		foreach ($this->user_scripts as $index => $script) {
			$scripts_string .= "\n<script type=\"text/javascript\">\n" . $script ."\n</script>\n";
		}
		$dom = new \DOMDocument;
		$dom->loadXML("<component>".$scripts_string."</component>");
		$s = simplexml_import_dom($dom);
		$this->sxml_append($xml_object,$s);
	}

	/**
     * ـ This function adds all of the elements entered by user to the entered xml_object
     * @param \SimpleXMLElement $xml_object The xml_object of the body part of the page
     * @param array $elements_array The array of the elements of page
     */
	private function sculptor_array2xml($xml_object,$elements_array){

		foreach ($elements_array as $tag_nick_name => $tag_array){

			$tag_name = "p";
			if (substr($tag_nick_name,0,3)=="cmp") {

				$dom = new \DOMDocument;
				$dom->loadXML("<component>".$tag_array["body_text"]."</component>");
				$s = simplexml_import_dom($dom);
				$this->sxml_append($xml_object,$s);

			}else if (substr($tag_nick_name,0,2)=="El"){
				$tag_name = substr($tag_nick_name,strpos($tag_nick_name, "_")+1);
				$added_element = $xml_object->addChild($tag_name,$tag_array["body_text"]);
				foreach ($tag_array['attributes'] as $attribute_name => $attribute_value) {
					$added_element->addAttribute($attribute_name,$attribute_value);
				}
				if (count($tag_array['children'])>0) {
					$this->sculptor_array2xml($added_element,$tag_array['children']);
				}
			}
	    }

	}

	/**
     * ـ This function adds a SimpleXMLElement to another
     * @param \SimpleXMLElement $to The SimpleXMLElement to be added another SimpleXMLElement
     * @param \SimpleXMLElement $from The SimpleXMLElement to add to another SimpleXMLElement
     */
	private function sxml_append(\SimpleXMLElement $to, \SimpleXMLElement $from) {
	    $toDom = dom_import_simplexml($to);
	    $fromDom = dom_import_simplexml($from);
	    $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
	}

	/**
     * ـ This function puts every element in the correct place in the main array of elements
     * @param array $all_elements_array The array of all elements
     */
	private function CorrectElementsArray($all_elements_array){
		if (count($all_elements_array)==0) {
				throw new Exception("There is no Element in Document", 1);
		}

		$considered_array = [];
		
		foreach ($all_elements_array as $father_id => $element_array) {

			if ($father_id=="body") {

				foreach ($element_array as $key => $element) {

					if (get_class($element)=="Sculptor\Element") {
						$considered_array["El-".rand()."_".$element->get_tag_name()]=["id"=>$element->get_id(),"body_text"=>$element->get_body_text(),"attributes"=>$element->get_attributes(),"children"=>[]];
						unset($all_elements_array[$father_id][$key]);
					}elseif (get_class($element)=="Sculptor\Component\Component") {
						$considered_array["cmp-".rand()."_".$key]=["body_text"=>$element->render()];
						unset($all_elements_array[$father_id][$key]);
					}

				}
				$this->temporary_corrected_array = $considered_array;
			}else{
				unset($all_elements_array["body"]);

				foreach ($element_array as $key => $element) {

					$father_found = false;
					
					$considered_array = &$this->temporary_corrected_array;

					if (count($considered_array)==0) {
						throw new \Exception("There is no element in the document for get rendered", 1);
					}

					while (!$father_found) {
						
						foreach ($considered_array as $tag_nick_name => $tag_array) {
							if ($tag_array['id']==$father_id) {

								$father_found = true;
								if (get_class($element)=="Sculptor\Element") {
									$considered_array[$tag_nick_name]['children']["El-".rand()."_".$element->get_tag_name()]=["id"=>$element->get_id(),"body_text"=>$element->get_body_text(),"attributes"=>$element->get_attributes(),"children"=>[]];
									unset($all_elements_array[$father_id][$key]);
								}elseif (get_class($element)=="Sculptor\Component\Component") {
									$considered_array[$tag_nick_name]['children']["cmp-".rand()."_".$key]=["body_text"=>$element->render()];
									unset($all_elements_array[$father_id][$key]);
								}

							}
						}

						if (!$father_found) {
							$assigned_array=[];
							foreach ($considered_array as $tag_nick_name => $tag_array) {
								 
								if (array_key_exists("children", $considered_array[$tag_nick_name])) {
									foreach ($considered_array[$tag_nick_name]['children'] as $ch_tag_nick_name => $ch_tag_array) {
										$assigned_array[$ch_tag_nick_name]=&$ch_tag_array;
									}
								}

							}
							$considered_array = &$assigned_array;
						}
					}

				}
				unset($all_elements_array[$father_id]);
			}
		}

	}

	/**
     * ـ This function erases the extra useless tags from the entered xml_string
     * @param string $xml_string The given xml_string
     * @return string The corrected string
     */
	private function erase_extra_tags($xml_string){
		$to_erase_array = ["<component><![CDATA[","<component>","</component>","]]></component>","<?xml version=\"1.0\"?>"];
		$return_string = str_replace($to_erase_array, "", $xml_string);
		return $return_string;
	}

	/**
     * ـ This function puts an element as the considered temporary_element
     * @param Element $current_element The element to be considered as the temporary_element
     * @return this The current instance of the class
     */
	public function __invoke($current_element){
		$this->temporary_element = $current_element;
		return $this;
	}

}

?>