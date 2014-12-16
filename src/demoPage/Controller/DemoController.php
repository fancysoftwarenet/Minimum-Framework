<?php
	class DemoController extends Controller
	{
		public function helloAction($args)
		{
			if ( empty($args) )
				return array("prenom" => "prenom par défaut");
			else
				return array("prenom" => $args[0]);
		}
		
		public function goodbyeAction($args)
		{
			return array('prenom' => $args[0], 'nom' => $args[1]);
		}
	}
?>