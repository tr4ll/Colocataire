<?php 
require_once "class/Utilisateur.php";

class EventAchat {

	private $_nom;
	
	private $_frequence;
        
        private $_dateDebut;
	
	private $_prix;
	
	private $_commentaire;
	
	private $_utilisateur;
	
	function __construct($nom,$prix,$frequence,$date,Utilisateur $utilisateur = null) {
		$this->_prix = $prix;
		$this->_nom = $nom;
		$this->_frequence = $frequence;
		$this->_utilisateur = $utilisateur;
                $this->_dateDebut = $date;
	}
	
	function setNom($nom) {
		$this->_nom = mysql_escape_string($nom);
	}
	
	function setCommentaire($commentaire) {  
		$this->_commentaire = mysql_escape_string($commentaire);
	}

	function getCommentaire() {
		return $this->_commentaire;
	}
        function getDateDebut() {
		return $this->_dateDebut;
	}
	function setDateDebut($date) {
		$this->_dateDebut = mysql_escape_string($date);
	}
	function setPrix($prix) {
		$this->_prix = $prix;
	}

	function setUtilisateur(Utilisateur $utilisateur) {
		$this->_utilisateur = $utilisateur;
	}
	
	function getUtilisateur() {
		return $this->_utilisateur;
	}	
	
	function getNom() {
		return $this->_nom;
	}	
	
	function getPrix() {
		$prix = str_replace(",",".",$this->_prix);
		return $prix;
	}
	function setFrequence($frequence) {
		$this->_frequence = $frequence;
	
	}
	
	function getFrequence() {
		return $this->_frequence;
	}
	
	//Exec event database Mysql
	public function createEvent() {
		$sql = "CREATE EVENT ".$this->_nom."
				ON SCHEDULE
                                EVERY 1 ".$this->_frequence." STARTS '".$this->_dateDebut." 00:00:00'
				COMMENT '".$this->_commentaire."'                                
				DO
                                    INSERT INTO `collocataire`.achat (prix,commentaire,fk_utilisateur,date,auto) 
                                    VALUES('".$this->_prix."','".$this->_commentaire."','".$this->_utilisateur->getLogin()."',CURDATE(),'1');";
		  
		return $sql;
	}
	
	public function dropEvent() {
		$sql = "DROP EVENT IF EXISTS ".$this->_nom.";";
		
		return $sql;
	}

}

?>