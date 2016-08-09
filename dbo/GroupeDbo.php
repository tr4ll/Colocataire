<?php 

require_once  "class/Groupe.php";

class GroupeDbo {

private $_pdo;

private $data;

function __construct (DataAccess $db) {
	$this->data = $db;
	$this->_pdo = $db->getDb();
}

function getGroupe($nom,$eager = false) {
		//Par default
		$groupe = new Groupe("admin");
		
		$sql = "SELECT * FROM groupe WHERE nom = '".mysql_escape_string($nom)."' LIMIT 0,1";
		echo (isset($_GET['DEBUG']) ? "<p class='debug'>GroupeDbo.GetGroupe:".$sql : "");
		
		foreach( $this->_pdo->query($sql) as $row ) {
			
			$groupe = new Groupe($nom);
			if ($eager == true)
				$groupe->setUtilisateurs( $this->data->getInstanceUtilisateur()->getUtilisateursByGroupe($groupe,true) );

			
		}
		return $groupe;
	}
	
function getGroupes() {
	
	$groupes = array();
	$sql = "SELECT * FROM groupe";
        echo (isset($_GET['DEBUG']) ? "<p class='debug'>GroupeDbo.GetGroupes:".$sql : "");
	foreach( $this->_pdo->query($sql) as $row ) {
	
		$groupe = new Groupe($row['nom']);
		array_push($groupes , $groupe);
		
	}
	//Retourne un tableau d'utilisateur
	return $groupes;
}

function saveGroupe(Groupe $groupe) {

	try {
		$sql = "INSERT INTO groupe(nom) VALUES('".$groupe->getNom()."')
				ON DUPLICATE KEY UPDATE nom = '".$groupe->getNom()."'";
                echo (isset($_GET['DEBUG']) ? "<p class='debug'>GroupeDbo.saveGroupe:".$sql : "");
		$result = $this->_pdo->exec($sql);
			
	}
	catch( PDOException $e ) {
		echo '<p class="text-error">Erreur lors de l\'insertion : '.$e->getMessage().'</p>';
	}
	//sauvegarde un groupe
	return $result;
	}	
	
function deleteGroupe($nom) {
	try {
		$result = $this->_pdo->exec("DELETE FROM groupe WHERE nom = '".$nom."';");	
                echo (isset($_GET['DEBUG']) ? "<p class='debug'>GroupeDbo.deleteGroupe:".$sql : "");
	}
	catch( PDOException $e ) {
		echo '<p class="text-error">Erreur lors de l\'insertion : '.$e->getMessage().'</p>';
	}
	//delete groupe
	return $result;

}

function getGroupeWhereUtilisateurIn($login,$eager = false) {
        //Par default
        $groupe = new Groupe("admin");

        $sql = "SELECT * FROM groupe WHERE nom = '".mysql_escape_string($nom)."' LIMIT 0,1";
        echo (isset($_GET['DEBUG']) ? "<p class='debug'>GroupeDbo.GetGroupe:".$sql : "");

        foreach( $this->_pdo->query($sql) as $row ) {

                $groupe = new Groupe($nom);
                if ($eager == true)
                        $groupe->setUtilisateurs( $this->data->getInstanceUtilisateur()->getUtilisateursByGroupe($groupe,true) );


        }
        return $groupe;
}
}
?>