<?php

namespace Sculptor\JS;

/**
* 
*/
class JSHandler
{

	function __construct($js_source)
	{
		$this->js_source=$js_source;
	}

	
	public function getMethodData($method_name){
		return "";
	}

	private function MethodsData(){
		return [
			"Events"=>[

							"pure"=>[

											"mouse"=>[

															"click" => ["equivalent"=>"click","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"contextmenu" => ["equivalent"=>"contextmenu","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"dblclick" => ["equivalent"=>"dblclick","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"mousedown" => ["equivalent"=>"mousedown","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"mouseenter" => ["equivalent"=>"mouseenter","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"mouseleave" => ["equivalent"=>"mouseleave","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"mousemove" => ["equivalent"=>"mousemove","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"mouseover" => ["equivalent"=>"mouseover","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"mouseup" => ["equivalent"=>"mouseup","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"mouseout" => ["equivalent"=>"mouseout","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],

													 ],	

											"keyboard"=>[

															"keydown" => ["equivalent"=>"keydown","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"keypress" => ["equivalent"=>"keypress","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"keyup" => ["equivalent"=>"keyup","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],

													    ],


											"frame_object"=>[

															"abort" => ["equivalent"=>"abort","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"beforeunload" => ["equivalent"=>"beforeunload","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"error" => ["equivalent"=>"error","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"hashchange" => ["equivalent"=>"hashchange","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"load" => ["equivalent"=>"load","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"pageshow" => ["equivalent"=>"pageshow","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"pagehide" => ["equivalent"=>"pagehide","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"resize" => ["equivalent"=>"resize","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"scroll" => ["equivalent"=>"scroll","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"unload" => ["equivalent"=>"unload","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],

													    	],


											"form"=>[

															"blur" => ["equivalent"=>"blur","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"change" => ["equivalent"=>"change","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"focus" => ["equivalent"=>"focus","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"focusin" => ["equivalent"=>"focusin","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"focusout" => ["equivalent"=>"focusout","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"input" => ["equivalent"=>"input","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"invalid" => ["equivalent"=>"invalid","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"reset" => ["equivalent"=>"reset","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"search" => ["equivalent"=>"search","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"select" => ["equivalent"=>"select","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],
															"submit" => ["equivalent"=>"submit","assigned"=>[0=>["name"=>"call_back","type"=>"function"]]],

													],

									],

							"jquery"=>[

											"change" => []

									],

					  ],
		];
	}

}

?>