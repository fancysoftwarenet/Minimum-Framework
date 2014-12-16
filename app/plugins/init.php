#!/usr/bin/php
<?php


function Init()
{
	$dossier = opendir ('./');

	$dossierPlugin = Array();
	while(false !== ($fichier = readdir($dossier)))
{
	
		if($fichier != '.' && $fichier != '..' && is_dir($fichier)){
			//echo $fichier ."\n";
			//echo "bonjour la boucle \n";
			array_push($dossierPlugin, $fichier);
		}
		
	
}

	$listeJsonPlugin = array();
	foreach ($dossierPlugin as $plugin){
	
				//echo "nice \n ";
			
				if (is_dir($plugin)){
				//echo "bonjour dossier \n";
				//echo "Plugin ciblé: ".$plugin ."\n" ;
				$filexist = $plugin.'/plugin.json';
				//var_dump (file_exists($filexist));
					
						if(file_exists($filexist)){
							$readfile = fopen($filexist,"r");
							$json = fread($readfile, filesize($filexist));
							//echo "JE SUIS ICI \n";
							//var_dump($json);
							$jsondecode = json_decode($json);
							//echo $jsondecode->{'name'}."\n";
							var_dump($jsondecode);
							
							$nom = ( isset($jsondecode->name) ) ? $jsondecode->name : "";
							$version = ( isset($jsondecode->version) ) ? $jsondecode->version : "";
							$main = ( isset($jsondecode->main) ) ? $jsondecode->main : "";
							$private = ( isset($jsondecode->private) ) ? $jsondecode->private : "";
							
								if($nom != ""){
						
									$nomTest = "OK";
								}
								else{
									echo "Vous n'avez pas rempli le champ nom de votre fichier.json \n";
									$nomTest = "";
								}	
								if($version != ""){
									//echo "LA VERSION EST LA \n";
									$versionTest = "OK";
								}
								else{
									echo "Vous n'avez pas rempli le champ version de votre fichier.json \n";
									$versionTest = "";
								}
								if($main != ""){
								//	echo "LE MAIN EST LA \n";
									$mainTest = "OK";
								}
								else{
									echo "Vous n'avez pas rempli le champ main de votre fichier.json \n";
									$mainTest = "";
								}	
								if($private == "false"){
									//echo "LE PRIVATE EST LA \n";
									$privateTest = "OK";
								}
								else{
									//echo "Vous n'avez pas rempli le champ private de votre fichier.json ou alors celui-ci est privé \n";
									$privateTest = "";
								}
						
						
						
								if($nomTest == "OK" && $versionTest == "OK" && $mainTest == "OK" && $privateTest == "OK"){
									array_push($listeJsonPlugin, $plugin."/".$main);
									echo("je push ceci : ".$plugin."/".$main."\n");
									//var_dump($listeJsonPlugin);
							
							
							
								}
						
						
								
						}
					
						else{	
						echo "Il n'y a aucun fichier plugin.json dans le dossier ".$filexist."\n ";
						}
		
				}
			}
	
	//var_dump($listeJsonPlugin);
	var_dump($listeJsonPlugin);
	$pluginOk = fopen ("./plugins-enabled.php", "w+");
	fwrite($pluginOk , "<?php\n");
	foreach ($listeJsonPlugin as $listeOk){
	echo "je passe ".$listeOk."\n";
	fwrite($pluginOk , "include \"" . $listeOk . "\";\n");
	}
	fwrite($pluginOk , "?>");
	fclose ($pluginOk);
}


Init();

?>