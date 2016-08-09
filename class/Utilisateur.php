<?php 
require_once "class/Groupe.php";

class Utilisateur {
        /**
         *
         * @var String 
         */
	private $_login;
	/**
         *
         * @var String 
         */
	private $_mdp;
	/**
         *
         * @var Groupe 
         */
	private $_groupe;
	/**
         *
         * @var String 
         */
	private $_mail;
	/**
         *
         * @var List<Achat> 
         */
	private $_achats = array();

        //La difference entre ce que doit le coloc et la moyenne des achats des coloc
	private $_difference;
	
        /**
         * Ce que doit payer le colocataires aux autres
         * @var List<Utilisateur> 
         */
	private $_payerColocataires = array();
	
        /**
         * Constructeur
         * @param type $login
         * @param type $mdp
         * @param Groupe $groupe 
         */
	function __construct($login = null,$mdp = null,Groupe $groupe =null) {
	
		$this->_login = $login;
		$this->_mdp = $mdp;
		$this->_groupe = $groupe;
	
	}
	function getLogin() {
		return $this->_login;
	}
	
	function getMdp() {
		return $this->_mdp;
	}
	
	function getGroupe() {
		return $this->_groupe;
	}
	
	function getMail() {
		return $this->_mail;
	}
	function getAchats() {
		return $this->_achats;
	}
	
	
	function setLogin($login) {
		$this->_login = $login;
	}
	
	function setMdp($mdp) {
		$this->_mdp = $mdp;
	}
	
	function setMail($mail) {
		$this->_mail = $mail;
	}
	function setGroupe(Groupe $groupe) {
		$this->_groupe = $groupe;
	}
	
	function setAchats($achats) {
		$this->_achats = $achats;
	}
	
	function setDifference($diff) {
		$this->_difference = $diff;
	}
	function getDifference() {
		return $this->_difference;
	}
	
	function calculNouvelleDifference($nb) {
		$this->_difference += $nb;
	}
	

        /**
         * Retourne la somme des achats collectifs non pay� d'un utilisateur
         * @param type $includeAchatAutre Si actif on n'inclue que les achats commun
         * @return type 
         */
	function calculerTotalAchatNonPaye($includeAchatAutre = false) {
		$result = 0;
		foreach ($this->_achats as $achat) {
			//Si l'achat n'a pas ete payer par les colloataires && que ce n'est pas un achat pour un auitre
			if (!$includeAchatAutre) {
				if ( !$achat->isPaye())
					//on fait la somme de tous ses achats
					$result += $achat->getPrix();	
			} else {
				if ( !$achat->isPaye() && $achat->getAchatColocataireAutre()->getLogin() == "")
					//on fait la somme de tous ses achats
					$result += $achat->getPrix();	
			}
		}
		return $result;
	}
	
	
	//Calcul la difference achat utilisateur moyenne groupe
	function differenceAchatUtilisateurMoyenne($moyenne) {
		$this->_difference =  $this->calculerTotalAchatNonPaye(true) -  $moyenne;
	}
	
	function getPayerColocataires() {
		return $this->_payerColocataires;
	}
        
	/**
         * Ajout des remboursement par colocataire
         * @param Utilisateur $colocataire le colocataire a rembourser
         * @param type $doitPayer la somme a rembourser
         */
	function addPayerColocataire(Utilisateur $colocataire,$doitPayer) {
		if ( isset( $this->_payerColocataires[$colocataire->getLogin()] ) ) 
			$this->_payerColocataires[$colocataire->getLogin()] += $doitPayer;
		else  
			$this->_payerColocataires[$colocataire->getLogin()] = $doitPayer; 

		echo (isset($_GET['DEBUG']) ? "<p class='debug'>Ajouter a la liste :".$colocataire->getLogin()."->".$doitPayer : "");
	}
        /**
         * Retourne les colocataires qui nous doivent de l'argent
         * @return 
         */
        function parsePayerColocataire() {
            $tmpColocataireDansLeNegatif = array();
            foreach ($this->_payerColocataires as $key => $value) {
                if ($value < 0) {
                    $tmpColocataireDansLeNegatif[$key] = $value;
                    removePayerColocataire($key);
                }
            }
            return $tmpColocataireDansLeNegatif;
        }
        /**
         * Enleve un remboursement de l'utilisateur
         * @param Utilisateur $colocataire 
         */
        function removePayerColocataire(Utilisateur $colocataire) {
            unset($this->_payerColocataires[$colocataire->getLogin()]);
            echo (isset($_GET['DEBUG']) ? "<p class='debug'>Enleve de la liste :".$colocataire->getLogin() : "");

        }
	/**
         * Affiche le detail des achats que doit rembourser le colocataire
         * @return string 
         */
	function printDetailARembourser() {
		$str = "";
		//print_r($this->_payerColocataires);
		foreach ( $this->_payerColocataires as $login => $value ) {
                        $class = ($value < 0 ? "label label-success" : "label label-important"); 
                        $str .= "<span style='font-size:10pt' class='".$class."'>"; 
			$str .= "Colocataire : ".$login. " => ";
			$str .= "". $value. " &euro;";
                        $str .= "</span>";
		}
		
		return $str;
	}
	
    /**
     *Permet de comparer 2 obj
     * @param type $b
     * @param type $a
     * @return boolean 
     */
    static function equals( $b , $a)
    {
        $al = $a->getLogin();
        $bl = $b->getLogin();
        if ($al == $bl) 
            return true;
        return false;
    }

/* Fonctions Comparaison Obj */
    /**
     * Trie descendant
     * @param type $a
     * @param type $b
     * @return int 
     */
    static function cmpDSC_obj($a, $b)
    {
        $al = $a->getDifference();
        $bl = $b->getDifference();
        if ($al == $bl) {
            return 0;
        }
        return ($al > $bl) ? +1 : -1;
    }
    /**
     * Trie ascendant
     * @param type $a
     * @param type $b
     * @return int
     */
    static function cmpASC_obj($a, $b)
    {
        $al = $a->getDifference();
        $bl = $b->getDifference();
        if ($al == $bl) {
            return 0;
        }
        return ($al < $bl) ? +1 : -1;
    }
/* FIN */
}
?>