#!/usr/bin/php
<?php

/*
    Vous entrez dans la 5 Dimension (Non dirigée par Baroin)
    Bienvenue dans le code de console le plus étrange :O
    #Minimum #FrameworkQuiPeseUnMax
*/

if ($argc < 2) {
    echo "Console V1 : compatible apache Debian OS\n";
    echo "Utilisation: {$argv[0]} <option> [args...]\n";
    echo "  generate:page        Génère une page standard (controller et view) suivant le type passe en paramètre\n";
    echo "  generate:plugin      Génère la base d'un plugin\n";
    echo "  plugins:init         Initialise les plugins\n";
    echo "  cache:clear         Vide le cache\n";
return;
}
//echo $argv[1] . "\n";

$arg1 = explode(":", $argv[1]);        //On scinde le premier argument en deux pour connaitre l'action à faire

if($arg1[0] == "generate"){              
    switch ($arg1[1]) {
        case 'page':
            echo "Template [base]: ";
            $handle = fopen ("php://stdin","r");    // On met la console en pause et on attend une ligne entrée par l'utilisateur
            $line = fgets($handle);                     // On récupère cette ligne dans unbe variable
            $template = (trim($line) == "") ? "base" : trim($line);     // Terniaire, si aucun template n'est entré, on met "base" a la place
            $fichierController = "../../resources/templates/" . $template . "/Controller.php";  // On définit les emplacement du controller et de la view
            $fichierView = "../../resources/templates/" . $template . "/View.html.twig";
            $page = "";
            while ($page == "") {
                echo "Nom de la page: ";    // Nom de la page a créer, se répète si aucune valeur
                $handle = fopen ("php://stdin","r");
                $line = fgets($handle);
                $page = trim($line);
            }
            mkdir("../../src/{$page}Page/Controller", 0755, true); // on crée les dossier pour le controller et les views
            mkdir("../../src/{$page}Page/Views", 0755, true);
            if(file_exists($fichierController)){    // On que le template du controller demande ligne 20 existe
                copy($fichierController, "../../src/{$page}Page/Controller/{$page}Controller.php");     // On copie ce controller dans le dossier créé
            }else{
                echo "Je ne connais pas ce type: {$template}\n";
            }

            //Generation d'actions
                $listActions = Array();
                echo "Boucle d'ajout d'actions\n";
                echo "Ajouter une action: ";
                $handle = fopen ("php://stdin","r");
                $line = fgets($handle);     // permiere action a ajouter ua controller
                while (trim($line) != ""){          // Tant que la ligne n'est pas vide, on continue a ajouter des actions
                    array_push($listActions, trim($line));
                    echo "Ajouter une action: ";
                    $handle = fopen ("php://stdin","r");
                    $line = fgets($handle);
                    //if()
                }
                $controllerAction = fopen("../../src/{$page}Page/Controller/{$page}Controller.php", "w+");
                fwrite($controllerAction, "<?php\nclass ".ucfirst($page)."Controller extends Controller\n{\n\n");
                foreach ($listActions as $action){
                    //echo "Action: {$action}\n"; // DEBUG
                    $args = '$args';
                    fwrite($controllerAction, "\tpublic function {$action}Action($args){\n\t\t\n\t\treturn array();\n\t}\n\n");     // On écrit le fichier controller avec la liste des actions

                    copy($fichierView, "../../src/{$page}Page/Views/{$action}.html.twig");
                }
                fwrite($controllerAction, "}\n?>");
                fclose($controllerAction);
            //Fin génération

            echo "La page {$page} vient d'être générée !\n";

            break;

        case 'plugin':  // Premier argument: plugin

            $nomPlugin = "";
            while ($nomPlugin == "") {
                echo "Nom plugin: ";
                $handle = fopen ("php://stdin","r");    // Le nom du plugin, boucle si null
                $line = fgets($handle);
                $nomPlugin = trim($line);
            }

            echo "Description du plugin: ";
            $handle = fopen ("php://stdin","r");
            $line = fgets($handle);
            $descPlugin = trim($line);

            echo "Fichier principal [main.php]: ";
            $handle = fopen ("php://stdin","r");
            $line = fgets($handle);
            $mainPlugin = (trim($line) == "") ? "main.php" : trim($line);

            echo "Version [0.1]: ";
            $handle = fopen ("php://stdin","r");
            $line = fgets($handle);
            $versionPlugin = (trim($line) == "") ? "0.1" : trim($line);

            echo "Plugin privé [false]: ";
            $handle = fopen ("php://stdin","r");
            $line = fgets($handle);
            $privatePlugin = (trim($line) == "") ? "false" : trim($line);

            //echo "Génération plugin , nom: {$nomPlugin} | version: {$versionPlugin} | private: {$privatePlugin}\n";
            echo "Génération du plugin {$nomPlugin} ({$versionPlugin}) en cours...\n";
            $plugin = Array('name' => $nomPlugin, 'description' => $descPlugin, 'version' => $versionPlugin, 'main' => $mainPlugin, 'private' => $privatePlugin);
            $jsonencode = json_encode($plugin, JSON_PRETTY_PRINT)."\n"; // On encapsule en JSON pour créer le fichier plugin.json
            mkdir("../plugins/{$nomPlugin}");
            touch("../plugins/{$nomPlugin}/plugin.json");
            $ficherJsonPlugin = fopen("../plugins/{$nomPlugin}/plugin.json", "w+");     // Ecriture du fichier plugin
            fwrite($ficherJsonPlugin, $jsonencode);
            fclose($ficherJsonPlugin);
            if(!file_exists("../plugins/{$nomPlugin}/{$mainPlugin}")){
                touch("../plugins/{$nomPlugin}/{$mainPlugin}");     // On crée le fichier main du plugin si il n'existe pas déjà
            }
            echo "Génération du plugin {$nomPlugin} ({$versionPlugin}) réussie !\n";
            break;

        default:
            echo "ERREUR: La génération du type '{$arg1[1]}' est inconnue et n'existe probablement pas !\n";
            echo "Liste des générations diponibles:\n";
            echo "    > generate:page\n";
            echo "    > generate:plugin\n";
            break;
    }
}else if($argv[1] == "cache:clear"){
    echo "Suppression du cache...\n";
    $dir = "../../cache/twig";
    rrmdir($dir);       // Permet de supprimer le cache de twig
    echo "Suppression du cache terminée !\n";
}else if($argv[1] == "plugins:init"){
    echo "Iinitialisation de vos plugins en cours...\n";
    echo "Just dig it !\n";
    chdir ("../plugins");
    exec("php init.php");       // On lance l'initialisation des plugins de la Mathieu Giorgiutti Corporation :P
    echo "initilisation de splugins terminée !\n";
}/*else if($arg1[0] == "--help" OR $arg1[0] == "-h" OR $arg1[0] == "-?"){
    echo "Utilisation: {$argv[0]} <option> [args...]\n";
    echo "  generate:page        Génère une page standard (controller et view) suivant le type passe en paramètre\n";
    echo "  generate:plugin      Génère la base d'un plugin\n";
    echo "  plugins:init         Initialise les plugins\n";
    echo "  cache:remove         Vide le cache\n";
}*/

function rrmdir($dir) { // Fonction de suppression recursive et magnifique, #MIINIMUM
    foreach(glob($dir . '/*') as $file) {
        if(is_dir($file))
            rrmdir($file);
        else
            unlink($file);
    }
    rmdir($dir);
}
?>
