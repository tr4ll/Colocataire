<?php 

class Email {
	private $_texte;
	private $_destinataire;
	private $_objet;

	//Objet : sujet du mail
	//Texte : texte en HTML
 function __construct(Utilisateur $user,$texte,$objet) {
 
	$this->_texte = str_replace("\n.", "\n..", $texte);
	$this->_objet = $objet;
	$this->_destinataire = $user->getMail();
	}
	
	function sendMail() {


     // Pour envoyer un mail HTML, l'en-t�te Content-type doit �tre d�fini
     $headers  = 'MIME-Version: 1.0' . "\r\n";
     $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

     // En-t�tes additionnels
     $headers .= 'From: Root <skynet@tux.free>' . "\r\n";
	 // Envoi
	 $return = mail($this->_destinataire, $this->_objet, $this->_texte, $headers); 
		
	echo $return ? "<p class='sucess'>Envoi du mail ".$this->_objet." &aeagrave; l'adresse suivante ".$this->_destinataire."</p>" :
	"<p class='label label-important'>Erreur ".$this->_objet." &eagrave; l'adresse suivante ".$this->_destinataire."</p>";	
	}
}

?>