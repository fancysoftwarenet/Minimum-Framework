<?php
	class DocController extends Controller
	{
		public function Action($args)
		{
			return $this->error404Action($args);
		}
		
		public function accueilAction($args)
		{
			return array('title' => "Accueil", 'style' => "./app/src/styles/base.css", 'titre_page' => 'Accueil');
		}
		
		public function startAction($args)
		{
			return array('titre_page' => "Comment débuter");
		}
		
		public function conventionsAction($args)
		{
			return array('titre_page' => 'Conventions de nomage');
		}
		
		public function error404Action($args)
		{
			return array('titre_page' => "Erreur 404");
		}
		
		public function fonctionnementAction($args)
		{
			return array('titre_page' => "Fonctionnement de Minimum");
		}
		
		public function consoleAction($args)
		{
			return array('titre_page' => "La console de Minimum");
		}
		
		public function pluginsAction($args)
		{
			return array('titre_page' => "Le manuel des plugins");
		}
	}
?>