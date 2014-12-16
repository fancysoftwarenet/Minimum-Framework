<?php
	//URL de la forme foo.com/page/action

	include "resources/global_variables.php";
	include "resources/functions.php";
	include "app/src/Page/Controller/Controller.php";
    include "app/plugins/plugins-enabled.php";
	require_once './resources/vendor/autoload.php'; 

	$cache = false;
	//$cache = "cache/twig"; //Décommenter pour activer le cache de twig
	
    $urlExplode = explode("/", $_SERVER['REQUEST_URI']);

    $i = 0;
    $args = Array(); //Contient les paramètres de l'url autres que la page et l'action

    foreach($urlExplode as $urlParam) //Supprime les cases vides de $urlExplode
    {
        if(strlen($urlParam)>=1)
        {
            if($i == 0)
            {
                $page = $urlParam;
                $controller = $urlParam;
            }else if ($i == 1){
            	$view = $urlParam;
            }else{
                array_push($args, $urlParam);
            }
            $i++;
        }
    }

	if ( !isset($page) ) //Si on a pas de page cible, on cible la page par défaut
	{
		$page = "default";
	}
	
	if ( !isset($view) )
	{
		$view = "default";
	}

	$folder = $page."Page";

	if ( count($urlExplode) < 2 ) //Si on a pas 2 arguments dans l'url
	{
		if ( empty($urlExplode[0]) && empty($urExplode[1]) ) //Si on a machin.com/
		{
			if ( !isset($urlExplode[0]) )
				array_push($urlExplode, "default");
			else if ( isset($urlExplode[0]) )
				$urlExplode[0] = "default";
		}
		if ( $urlExplode[0] == "default" && count($urlExplode) < 2 ) //Si on a "machin.com/default"
			if ( empty($urlExplode[1]) )
				$urlExplode[1] = "default";
	}
	
	
	//On prépare le controlleur
	$controllerName = ucwords($page)."Controller";

	$action = $view."Action";
	$view = strtolower($view.".html.twig");
	
	
	//On prépare TWIG et donc on vérifie les matchs de route

	$loader=new Twig_Loader_Filesystem( array("./app/src/Page/Views", "extends/")); //Les views du controlleur par défaut et du dossier des layouts, toujours incluses

	if (file_exists('./src/'.$folder.'/Views/'.$view ) ) //Si la view existe
	{
		$loader->addPath('./src/'.$folder.'/Views'); //Donne le dossier qui contient les vues du controlleur demadé
		include "./src/".strtolower($page)."Page/Controller/".strtolower($page)."Controller.php"; //On inclut le code du controlleur
	}
	else //Si aucune route ne matche on sort une 404
	{
		$controller = new Controller; //Controlleur par défaut instancié
		$twig = new Twig_Environment($loader, array('cache' => $cache));
		
		header('HTTP/1.0 404 Not Found');
		echo $twig->render('e404.html.twig', $controller->e404Action($args));
		return;
	}

	$controller = new $controllerName;
	$twig = new Twig_Environment($loader, array('cache' => $cache)); //L'environnement, prends le loader puis le dossier de cache

	echo ($twig->render($view, $controller->$action($args)));
?>
