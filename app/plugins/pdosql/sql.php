<?php
class SQL
{
    private $_host = "localhost";
    private $_user = "root";
    private $_password = "";
    private $_dbname = "dbname";


    /// <summary>
    //  Exemple de connexion:
    //  $bdd = new SQL();
    //  $connexion = $bdd->open();
    /// </summary>
    public function open(){
        try {
            $dns = "mysql:host={$this->_host};dbname={$this->_dbname}";
            $utilisateur = $this->_user;
            $motDePasse = $this->_password;
            $connection = new PDO( $dns, $utilisateur, $motDePasse );

            return $connection;
        } catch ( Exception $e ) {
            echo "Connection à MySQL impossible : ", $e->getMessage();
            die();
        }
    }
}
?>
