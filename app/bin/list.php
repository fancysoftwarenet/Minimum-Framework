<?php

function ls($repertoire, $visible)
{
	$dir = opendir($repertoire) or die('Erreur de listage : le r�pertoire ' . $repertoire . ' n\'existe pas');
	$fichiers = array(); // on d�clare le tableau contenant le nom des fichiers
	$dossiers = array(); // on d�clare le tableau contenant le nom des dossiers

	while($element = readdir($dir)) {
		if($element != '.' && $element != '..') {
			if (!is_dir($repertoire.'/'.$element)) {$fichiers[] = $element;}
			else {$dossiers[] = $element;}
		}
	}

	closedir($dir);

	if ($visible)
	{
		if(!empty($dossiers)) 
		{
			sort($dossiers); // pour le tri croissant, rsort() pour le tri d�croissant
			echo "Liste des dossiers accessibles dans " . $repertoire . " : \n\n";
			echo "\t\t<ul>\n";
				foreach($dossiers as $lien){
					echo "\t\t\t<li><a href=\"" . $repertoire . "/" . $lien . "\">" . $lien . "</a></li>\n";
				}
			echo "\t\t</ul>";
		}

		if(!empty($fichiers))
		{
			sort($fichiers);// pour le tri croissant, rsort() pour le tri d�croissant
			echo "Liste des fichiers/documents accessibles dans " . $repertoire . " : \n\n";
			echo "\t\t<ul>\n";
				foreach($fichiers as $lien) {
					echo "\t\t\t<li><a href=\"$repertoire/$lien \">$lien</a></li>\n";
				}
			echo "\t\t</ul>";
		}
	}
	
	return array('fichiers' => $fichiers, 'dossiers' => $dossiers);
}
?>