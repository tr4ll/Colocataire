<?php 

require_once "class/Utilisateur.php";

class UtilisateurDbo {
	
	private $_pdo;
	
	private $_groupePdo;
	
	private $_achatPdo;
	
	private $data;
        
        private $_utilisateurs = array();
        
	function __construct (DataAccess $db) {
		$this->_pdo = $db->getDb();
		$this->data = $db;
	}
	
	
	function getUtilisateur($login,$eager = false) {
                //TODO ameliorer performance avec un singleton
                //if (array_key_exists($login,$this->_utilisateurs))
                //        return $this->_utilisateurs($login);
                
		$utilisateur = new Utilisateur('','',new Groupe(''));
		$sql = "SELECT * FROM utilisateur WHERE login = '".mysql_escape_string($login)."' LIMIT 0,1";
		echo (isset($_GET['DEBUG']) ? "<p class='debug'>UtilisateurDbo.getUtilisateur:".$sql : "");

		foreach( $this->_pdo->query($sql) as $row ) {
			$utilisateur = new Utilisateur($row['login'],$row['mdp'], $this->data->getInstanceGroupe()->getGroupe($row['fk_groupe'],$eager));
			//on set les option
			$utilisateur->setMail($row['mail']);
		}
                
                //$this->_utilisateurs[$login] = $utilisateur;
                //var_dump($this->_utilisateurs);
		return $utilisateur;
	}
	function test() {
            
        }
	function saveUtilisateur(Utilisateur $utilisateur) {

		try {
			
			$result = $this->_pdo->exec("INSERT INTO utilisateur(login,fk_groupe,mdp,mail) VALUES('".$utilisateur->getLogin()."','".$utilisateur->getGroupe()->getNom()."','".md5($utilisateur->getMdp())."','".$utilisateur->getMail()."')
			ON DUPLICATE KEY UPDATE fk_groupe='".$utilisateur->getGroupe()->getNom()."', mdp = '".md5($utilisateur->getMdp())."', mail = '".$utilisateur->getMail()."';");
			echo (isset($_GET['DEBUG']) ? "<p class='debug'>UtilisateurDbo.saveUtilisateur:".$sql : "");


		}
		catch( PDOException $e ) {
			echo '<p class="text-error">Erreur lors de l\'insertion : '.$e->getMessage().'</p>';
		}
		//sauvegarde un utilisateur
	return $result;
	}
	
	public function deleteUtilisateur($login) {
		try {
			$result = $this->_pdo->exec("DELETE FROM utilisateur WHERE login = '".$login."';");		
		}
		catch( PDOException $e ) {
			echo '<p class="text-error">Erreur lors de l\'insertion : '.$e->getMessage().'</p>';
		}
		//delete user
		return $result;
	
	}
	
	public function getUtilisateursByGroupe(Groupe $groupe,$eager = false) {
	
	$utilisateurs = array();
	$sql = "SELECT * FROM utilisateur WHERE fk_groupe = '".$groupe->getNom()."'";
	echo (isset($_GET['DEBUG']) ? "<p class='debug'>UtilisateurDbo.getUtilisateursByGroupe:".$sql : "");

	foreach( $this->_pdo->query($sql) as $row ) {
	
		$utilisateur = new Utilisateur($row['login'],$row['mdp'],$this->data->getInstanceGroupe()->getGroupe($row['fk_groupe']));
		$utilisateur->setMail($row['mail']);
		if ($eager == true)
			$utilisateur->setAchats( $this->data->getInstanceAchat()->getAchatsByUtilisateur( $utilisateur ) );
		array_push($utilisateurs , $utilisateur);
		
	}
	//Retourne un tableau d'utilisateur
	return $utilisateurs;
}


	public function getUtilisateurs() {
	
	$utilisateurs = array();
	$sql = "SELECT * FROM utilisateur";
        echo (isset($_GET['DEBUG']) ? "<p class='debug'>UtilisateurDbo.getUtilisateurs:".$sql : "");
	foreach( $this->_pdo->query($sql) as $row ) {
	
		$utilisateur = new Utilisateur($row['login'],$row['mdp'],$this->_groupePdo->getGroupe($row['fk_groupe']));
		$utilisateur->setMail($row['mail']);
		array_push($utilisateurs , $utilisateur);
		
	}
	//Retourne un tableau d'utilisateur
	return $utilisateurs;
}
	
}
?>