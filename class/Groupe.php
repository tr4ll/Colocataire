<?php 

require_once "class/Utilisateur.php";

class Groupe {

	private $_nom;
	
        //List<Utilisateur>
	private $_utilisateurs = array();
	//Nombre de transaction a effectue
	private $transaction = 0;


	function __construct($nom) {
		$this->_nom = $nom;
	}
	
	function getUtilisateurs() {
		return $this->_utilisateurs;
	}
	
	function getNom() {
		return $this->_nom;
	}
	
	function setUtilisateurs($utilisateurs) {
		$this->_utilisateurs = $utilisateurs;
	}
	
	function setNom($nom) {
		$this->_nom = $nom;
	}
	
	/**
         *Calcul de la moyenne des achats du groupe
         * Ajoute les achats perso
         * @return double moyenne achat du groupe 
         */
	function calculerMoyenne() {
		
		$totalAchatGroupe = 0;
		$totalUtilisateur = 0;

		
		foreach ( $this->_utilisateurs as $utilisateur ) {
			//La somme des achats de tous les utilisateurs non pay�s
			foreach ( $utilisateur->getAchats() as $achat )
			{
				$result = 0;
				//On prend que les achat commun non paye 
				if (!$achat->isPaye() && $achat->getAchatColocataireAutre()->getLogin() == "" )
					$result = $achat->getPrix();
					
				//On ajoute les achats pay� pour d'autre coloc (achat perso)
				if (!$achat->isPaye() && $achat->getAchatColocataireAutre()->getLogin() != "") {
					if( isset($_GET['DEBUG']) )
                                            echo "<p class='debug'>Achat perso :".$achat->getAchatColocataireAutre()->getLogin()." Paye par :".$achat->getUtilisateur()->getLogin()." de ".$achat->getPrix();
					//Obliger de parcourir la liste de nouveau
					foreach ($this->_utilisateurs as $tmpU) {
						if ( $tmpU->equals($tmpU,$achat->getAchatColocataireAutre()) )
							//On ajoute a la facture du coloc
							$tmpU->addPayerColocataire($achat->getUtilisateur(),$achat->getPrix());
					}
										
					
				}	
				$totalAchatGroupe += $result;
			}
			
			
			$totalUtilisateur++;
		}
		//Calcul de la moyenne
		return ( $totalAchatGroupe / $totalUtilisateur);
		
	}

	/**
         * Calcul de la difference pour chaque utilisateur du groupe 
         */
	protected function calculerDifferenceParUtilisateur() {
		
		$moyenne = $this->calculerMoyenne();
		echo isset($_GET['DEBUG']) ?  "<p>moyenne Groupe:".$moyenne: '';
		//Calcul des diff de chaqun
		foreach ( $this->_utilisateurs as $colocataire ) {		
			$colocataire->differenceAchatUtilisateurMoyenne($moyenne);		
		}
		
	}
 
        /**
         * Calcul des sommes dues pour chaque colocataire faisant parti du groupe 
         */
	function calculGroupe() {
	
	$this->calculerDifferenceParUtilisateur();
	
	//Coloc ecxedant
	$tmpColocs = array();
	//Coloc deficitaire
	$tmpColocsDeficitaire = array();
	
	//On split les coloc excedantaire et deficitaire
	foreach ( $this->_utilisateurs as $colocataire ) {
		$colocataire->getDifference() > 0 ? array_push($tmpColocs,$colocataire) : array_push($tmpColocsDeficitaire,$colocataire);
	}
	
	//On trie le tableaux du plus grand excedant au plus petit
	usort($tmpColocs,array("Utilisateur","cmpASC_obj"));
	//On trie le tableaux du plus petit deficitaire au plus grand
	usort($tmpColocsDeficitaire,array("Utilisateur","cmpDSC_obj"));
	
	foreach ( $tmpColocsDeficitaire as $colocataire ) {
		if( isset($_GET['DEBUG']) ) {  
			echo "<p class='debug'>Coloc def :".$colocataire->getLogin();
			echo "<p class='debug'>Coloc dif :".$colocataire->getDifference();
			echo "<p class='debug'>nb Exedant :".count($tmpColocs);
		}
		 $tmpColocs = $this->calculColocataireDoitAuxColocataires($tmpColocs,$colocataire);
	}
        
        //Fin calcul des sommes dues pour chaque colocataires
	echo (isset($_GET['DEBUG']) ?  "<p class='debug'>Nb transaction :".$this->transaction : '');
	}
	

        /**
         *
         * @param List<Colocataire> $tmpColocs On recupere tous les coloc exedant
         * @param Utilisateur $coloc Celui qui doit de l'argent
         * @return array 
         */
	protected function calculColocataireDoitAuxColocataires(array $tmpColocs,Utilisateur $coloc) {
			$j = 0;
			//On parcours la liste des colocs qui sont exedant
			foreach ( $tmpColocs as $colocExcedant )
			{
				echo (isset($_GET['DEBUG']) ? "<p class='debug'>Excedant ".$colocExcedant->getDifference()." ".$colocExcedant->getLogin() : "");
				echo (isset($_GET['DEBUG']) ? "<p class='debug'>Deficit ".$coloc->getDifference()." ".$coloc->getLogin() : "");

					//Si le colocataire exedant n'a pas assez
					if (  $colocExcedant->getDifference() < $coloc->getDifference() *(-1) ) {

						//On donne de l'argent au colocataire exedant
						$coloc->calculNouvelleDifference($colocExcedant->getDifference());
						$this->transaction++;
						$coloc->addPayerColocataire($colocExcedant,$colocExcedant->getDifference());
						echo (isset($_GET['DEBUG']) ?  "<p class='debug'>Paye to ".$colocExcedant->getLogin()." somme :".$colocExcedant->getDifference()." Fin" : '');
						//On enleve le coloc exedant
						unset($colocExcedant);
						continue;
					}
					
					//on soustrait la diff ( colocExedant +  (-)colocCourant (neg) )
					$colocExcedant->calculNouvelleDifference( $coloc->getDifference() );
					//On paye la difference que l'on doit
					$coloc->addPayerColocataire( $colocExcedant , $coloc->getDifference() * (-1) );							
					$this->transaction++;
					echo (isset($_GET['DEBUG']) ?   "<p class='debug'>Paye to ".$colocExcedant->getLogin()." somme :".$coloc->getDifference() * (-1): '');
					
                                        //On regarde si on peut optimiser le nb de transaction (achat perso)
                                        if ( count($tmprembourseColoc = $colocExcedant->getPayerColocataires()) != 0 ) {
                                           
                                            foreach ($tmprembourseColoc as $tmpLogin => $doit2){
                                                //Si le coloc exedant courant doit deja de l'argent au coloc en deficit
                                                if ($tmpLogin == $coloc->getLogin()) {
                                                    $coloc->addPayerColocataire($colocExcedant, $doit2*(-1));//On enleve une partie du remboursement
                                                    $colocExcedant->removePayerColocataire($coloc); //On enleve le remboursement perso
                                                }
                                            }
                                        } 
					//On sort car on ne doit plus rien
					break;
					
			}
			
			return $tmpColocs;
			
	}
        

}

?>