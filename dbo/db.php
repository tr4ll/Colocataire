<?php 

require_once "conf/var.php";
require_once "dbo/UtilisateurDbo.php";
require_once "dbo/GroupeDbo.php";
require_once "dbo/AchatDbo.php";
require_once "dbo/EventAchatDbo.php";
require_once "dbo/FileFromDb.php";

class DataAccess {

private $_pdo;

//Constructeur
function __construct() {
}

//Fonction d'initialisation � la bdd
public function getDb() {
	if (!empty($this->_pdo))
		return $this->_pdo;
	
	try{
        $this->_pdo = new PDO('mysql:host=127.0.0.1;dbname=collocataire',USER, PASSWORD);
		$this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->_pdo->exec("SET CHARACTER SET utf8");
		echo (isset($_GET["DEBUG"]) ? "<p class='debug'>Connection r&eacute;ussie</p>" : ""); 
        }
        catch (PDOException $e)
        {
            echo '<p class="text-error">Erreur de connection : '.$e->getMessage().'</p>';
            return;
        } 
		
	return $this->_pdo;
}

//Retourne l'instance d'achat pour l'access au donn�e
public function getInstanceAchat() {
	return new AchatDbo($this);
}

//Retourne l'instance de groupe pour l'access au donn�e
public function getInstanceGroupe() {
	return new GroupeDbo($this);
}

//Retourne l'instance d'utilisateur pour l'access au donn�e
public function getInstanceUtilisateur() {
	return new UtilisateurDbo($this);
}

//Retourne l'instance d'evenement d'achat pour l'access au donn�e
public function getInstanceEventAchat() {
	return new EventAchatDbo($this);
}

//Retourne l'instance de la gestion des fichiers en base
public function getInstanceFileFromDb() {
	return new FileFromDb($this);
}
}

?>