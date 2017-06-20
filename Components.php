<?php

namespace Sculptor\Component;

require_once 'components/component.php';

/**
 * ـ This is the handler class for components in the system
 * @author Ali Souri ap.alisouri@gmail.com
 * @package Sculptor
 */
class Components
{
	
	/**
     * ـ Constructor of class
     * @param string $css_source The string name of the considered css source
     * @param string $extra_path The address of extra template files
     */
	function __construct($css_source,$extra_path = null)
	{
		if (in_array($css_source, $this->allowed_css_sources)) {
			$this->css_sources_paths['system'] = __DIR__."/components/templates/".$css_source;
		}elseif ((!is_null($css_source))&&($css_source!="")) {
			throw new Exception("Not Available Css Source Name", 1);
		}else{
			$this->css_sources_paths['system'] = $css_source;
		}
		if (!is_null($extra_path)) {
			$this->css_sources_paths['custom'] = $extra_path;	
		}
	}

	/** @var array Of the name of allowed css sources */
	private $allowed_css_sources = ["bootstrap","jquery"];

	/** @var array Of the address of extra template files */
	private $css_sources_paths = [];	

	/**
     * ـ This function makes a Component object which represents a bunch of html tags
     * @param string $component_name The name of considered html component
     * @param array $component_data The array of information for making a component
     * @return Component The Component object made by entered information
     */
	public function makeComponent($component_name,$component_data){
		
			if (array_key_exists("custom", $this->css_sources_paths)) {
				if (file_exists($this->css_sources_paths["custom"].$component_name.".twig")) {
					$template_file = fopen($this->css_sources_paths["custom"].$component_name.".twig", "r") or die("Considered template file could not be read.");
					$file_string = fread($template_file,filesize($this->css_sources_paths["custom"].$component_name.".twig"));
					fclose($template_file);
					return new Component($component_name,$component_data,$file_string);
				}elseif (file_exists($this->css_sources_paths["custom"].$component_name.".html.twig")) {
					$template_file = fopen($this->css_sources_paths["custom"].$component_name.".html.twig", "r") or die("Considered template file could not be read.");
					$file_string = fread($template_file,filesize($this->css_sources_paths["custom"].$component_name.".html.twig"));
					fclose($template_file);
					return new Component($component_name,$component_data,$file_string);
				}
			}
			if ((!is_null($this->css_sources_paths['system']))&&($this->css_sources_paths['system']!="")) {
				if (file_exists($this->css_sources_paths["system"]."/".$component_name.".twig")) {
					$template_file = fopen($this->css_sources_paths["system"]."/".$component_name.".twig", "r") or die("Considered template file could not be read.");
					$file_string = fread($template_file,filesize($this->css_sources_paths["system"]."/".$component_name.".twig"));
					fclose($template_file);
					return new Component($component_name,$component_data,$file_string);
				}elseif (file_exists($this->css_sources_paths["system"]."/".$component_name.".html.twig")) {
					$template_file = fopen($this->css_sources_paths["system"]."/".$component_name.".html.twig", "r") or die("Considered template file could not be read.");
					$file_string = fread($template_file,filesize($this->css_sources_paths["system"]."/".$component_name.".html.twig"));
					fclose($template_file);
					return new Component($component_name,$component_data,$file_string);
				}else{
					throw new \Exception("Considered component does not exist in the system.", 2);
				}
			}else{
				throw new \Exception("No Address for template files.", 1);
			}
		
	}


}

?>