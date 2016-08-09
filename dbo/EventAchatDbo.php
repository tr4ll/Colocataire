<?php 

require_once  "class/EventAchat.php";
require_once  "dbo/UtilisateurDbo.php";

class EventAchatDbo {

private $_pdo;

	function __construct (DataAccess $db) {
		$this->_pdo = $db->getDb();
		$this->_utilisateurDbo = new UtilisateurDbo($db);
		//On init le scheduler
		
	}

	function getEventAchat($nom) {
		$eventAchat = null;
		$sql = "SELECT * FROM event_achat WHERE nom = '".mysql_escape_string($nom)."' LIMIT 0,1";
		foreach( $this->_pdo->query($sql) as $row ) {
			$eventAchat = new EventAchat($row['nom'],$row['prix'],$row['frequence'],$row['date_debut'],null);
			$eventAchat->setCommentaire($row['commentaire']);
		}
		return $eventAchat;
	}
		
	function saveEventAchat(EventAchat $eventAchat) {
	try {
		$sql = "INSERT INTO event_achat(prix,nom,frequence,fk_utilisateur,commentaire,date_debut) 
		VALUES('".$eventAchat->getPrix()."',
		'".$eventAchat->getNom()."',
		'".$eventAchat->getFrequence()."',
		'".$eventAchat->getUtilisateur()->getLogin()."',
		'".$eventAchat->getCommentaire()."',
                '".$eventAchat->getDateDebut()."')
				ON DUPLICATE KEY UPDATE prix = '".$eventAchat->getPrix()."',
				nom = '".$eventAchat->getNom()."',
				frequence = '".$eventAchat->getFrequence()."',
				fk_utilisateur = '".$eventAchat->getUtilisateur()->getLogin()."',
				commentaire = '".$eventAchat->getCommentaire()."',
                                date_debut = '".$eventAchat->getDateDebut()."';";
		
		
		$result = $this->_pdo->exec($sql);
			
	}
	catch( PDOException $e ) {
		echo '<p class="text-error">Erreur lors de l\'insertion : '.$e->getMessage().'</p>';
	}
	//sauvegarde un achat
	
	//exec l'event
	try {
		//On supprime l'event si il existe
		$this->_pdo->exec($eventAchat->dropEvent());
		//Puis on le cr�er	
		$this->_pdo->exec($eventAchat->createEvent());
	}
	catch( PDOException $e ) {
		echo '<p class="text-error">Erreur lors de l\'insertion de l\'evenement : '.$e->getMessage().'</p>';
	}
	return $result;
	}
	
	public function deleteEventAchat($nom) {
		try {
			$result = $this->_pdo->exec("DELETE FROM event_achat WHERE nom = '".$nom."';");		
		}
		catch( PDOException $e ) {
			echo '<p class="text-error">Erreur lors de l\'insertion : '.$e->getMessage().'</p>';
		}
			//exec l'event
		try {
			//On supprime l'event si il existe
			//TODO cracra
			$ev = new EventAchat($nom,'','',null);
			$result = $this->_pdo->exec($ev->dropEvent());
		}
		catch( PDOException $e ) {
			echo '<p class="text-error">Erreur lors de l\'insertion de l\'evenement : '.$e->getMessage().'</p>';
		}

	return $result;
	
	}
	
	public function getEventAchatsByUtilisateur(Utilisateur $utilisateur) {
	
		$eventAchats = array();
		$sql = "SELECT * FROM event_achat WHERE fk_utilisateur = '".$utilisateur->getLogin()."'";
		foreach( $this->_pdo->query($sql) as $row ) {
		
			$eventAchat = new EventAchat($row['nom'],$row['prix'],$row['frequence'],$row['date_debut'],$utilisateur);
			$eventAchat->setCommentaire($row['commentaire']);
			
			array_push($eventAchats , $eventAchat);
			
		}
		//Retourne un tableau d'utilisateur
		return $eventAchats;
	}
	

}

?>