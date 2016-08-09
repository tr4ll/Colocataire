<?php 
 
require_once "class/Utilisateur.php";

class Achat 
{

	private $_id;
	
	private $_prix;
	
	private $_date;
	
	private $_commentaire;
	
	private $_utilisateur;
	
	private $_paye = false;
	
	private $_datePaye;
	
	//Est ce que l'achat est pour un autre colocataire
	private $_achatColocataireAutre;
	
	private $_achatAutomatique = false;
	
	//OLD
	private $_partage = false;
        
        //Pieces jointes -> on stock le flux du fichier au moment de l'ecriture, en lecture on stock l'id du fichier
        private $_attachments = array();
	
	function __construct($prix = null,$date = null,Utilisateur $utilisateur = null,$commentaire = null,$auto = null) {
		$this->_prix = $prix;
		$this->_date = $date;
		$this->_utilisateur = $utilisateur;
		$this->_commentaire = $commentaire;
		$this->_achatAutomatique = $auto;
	}
	
        ///////////////////////////////////////
        //          GETTER / SETTER         //
        /////////////////////////////////////
	function getId() {
		return $this->_id;
	}
	
	function getPrix($format = true) {
	return $format ? str_replace(".",",",$this->_prix) : $this->_prix;
	}
	
	function getDate() {
		return $this->_date;
	}
	
	function getDatePaye() {
		return $this->_datePaye;
	}
	function getUtilisateur() {
		return $this->_utilisateur;
	}
	
	function getAchatColocataireAutre() {
		return $this->_achatColocataireAutre;
	}
	//OLD
	function isPaye() {
		return $this->_paye;
	}
	
	function isAchatAutomatique() {
		return $this->_achatAutomatique;
	}
	
	function isPartage() {
		return $this->_partage;
	}
	
	function getCommentaire() {
		return $this->_commentaire;
	}
        function getAttachments() {
		return $this->_attachments;
	}
        function getAttachment($id) {
		return $this->_attachments[$id];
	}	
	function setCommentaire($commentaire) {
		$this->_commentaire = $commentaire;
	}
	
	function setDate($date) {
		$this->_date = $date;
	}
	
	function setDatePaye($date) {
		$this->_datePaye = $date;
	}
	
	function setUtilisateur(Utilisateur $utilisateur) {
		$this->_utilisateur = $utilisateur;
	}
	
	function setAchatColocataireAutre(Utilisateur $utilisateur) {
		$this->_achatColocataireAutre = $utilisateur;
	}
	function setPrix($prix) {
		$this->_prix = $prix;
	}
	
	function setPaye($paye) {
		$this->_paye = $paye;
	}
	
	function setPartage($partage) {
		$this->_partage = $partage;
	}
	
	function setAchatAutomatique($auto) {
		$this->_achatAutomatique = $auto;
	}
	
	function setId($id) {
		$this->_id = $id;
	}
        
        ///////////////////////////////////////
        //          ADD / REMOVE (LIST)     //
        /////////////////////////////////////        
        function addAttachment($file) {
		array_push($this->_attachments,$file);
	}
}
?>