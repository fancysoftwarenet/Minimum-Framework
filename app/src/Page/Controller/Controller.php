<?php
	class Controller
	{
		public function Action($args)
		{
			return array('titre_page' => "Erreur");
		}
		
		public function e404Action($args)
		{
			return array('Titre_page' => "Erreur 404");
		}
	}
?>