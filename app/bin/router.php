<?php

class routeur 
{
	private $_routing_yml;
	
	function __construct($routing){
		$this->_routing_yml = $routing;
	}

	public function route(){
		$fichier = fopen($this->_routing_yml, "r") or die("Erreur: impossible d'ouvrir routing.yml");
	
		//retourne un tableau de tableaux ['prefix']['args']['instance du controller']	
	}	
}

?>