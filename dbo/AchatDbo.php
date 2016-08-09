<?php 

require_once  "class/Achat.php";
require_once  "class/Email.php";
require_once  "dbo/UtilisateurDbo.php";

class AchatDbo {

private $data;

private $_pdo;

//private $_utilisateurDbo;

function __construct (DataAccess $db) {
	$this->data = $db;
	$this->_pdo = $db->getDb();
	//$this->_utilisateurDbo = new UtilisateurDbo($db);
}

function getAchat($id) {
                $achat = new Achat();
		$sql = "SELECT * FROM achat WHERE id = '".mysql_escape_string($id)."' LIMIT 0,1";
		echo (isset($_GET['DEBUG']) ? "<p class='debug'>GetAchat".$sql : "");
		foreach( $this->_pdo->query($sql) as $row ) {
			$achat = new Achat($row['prix'],$row['date'],$this->data->getInstanceUtilisateur()->getUtilisateur($row['fk_utilisateur']),$row['commentaire'],$row['auto']);
			$achat->setId($row['id']);
			$achat->setPaye($row['paye']);
			$achat->setDatePaye($row['date_paye']);
			$achat->setAchatColocataireAutre($this->data->getInstanceUtilisateur()->getUtilisateur($row['paye_to']));
			}
		return $achat;
	}
	
	function saveAchat(Achat $achat) {
	//O enregistre au format demand par la base
	$prix = str_replace(",",".",$achat->getPrix());
	try {
		$sql = "INSERT INTO achat(prix,fk_utilisateur,date,paye,commentaire,id,paye_to) 
		VALUES('".$prix."',
		'".$achat->getUtilisateur()->getLogin()."',
		'".$achat->getDate()."',
		'".$achat->isPaye()."',
		'".$achat->getCommentaire()."',
		'".$achat->getId()."',
		'".$achat->getAchatColocataireAutre()->getLogin()."')
				ON DUPLICATE KEY UPDATE 
				prix = '".$prix."',
				fk_utilisateur = '".$achat->getUtilisateur()->getLogin()."',
				date = '".$achat->getDate()."', 
				paye= '".$achat->isPaye()."', 
				paye_to ='".$achat->getAchatColocataireAutre()->getLogin()."',
				commentaire = '".$achat->getCommentaire()."'";
		
		echo (isset($_GET['DEBUG']) ? "<p class='debug'>save Achat:".$sql : "");
                $result = $this->_pdo->exec($sql);
                //TODO : integrer dans la classe GestionFichier
                //retourne l'id de l'achat
                 $id = $this->_pdo->lastInsertId();
                 if( isset($id) ) $achat->setId($id);
                foreach( $achat->getAttachments() as $attachment) {
                    $sql = "INSERT INTO attachment(fk_achat,file,type) VALUES(?,?,?)";                     
                    $statment = $this->_pdo->prepare($sql);

                    $fp = fopen($attachment['tmp_name'], 'rb');  
                    $statment->bindParam(1, $achat->getId());
                    $statment->bindParam(2, $fp, PDO::PARAM_LOB);
                    $statment->bindParam(3, $attachment['type']);
                    $this->_pdo->beginTransaction();
                    $statment->execute();
                    $this->_pdo->commit();
                    echo (isset($_GET['DEBUG']) ? "<p class='debug'>insert piece jointe:".$sql.";id=".$id : '');
                }                            
				
	}
	catch( PDOException $e ) {
		echo '<p class="text-error">Erreur lors de l\'insertion : '.$e->getMessage().'</p>';
	}
	//sauvegarde un achat
	return $result;
	}
	
	public function deleteAchat($id) {
		try {
			$result = $this->_pdo->exec("UPDATE achat set is_deleted=true WHERE id = '".$id."';");		
		}
		catch( PDOException $e ) {
			echo '<p class="text-error">Erreur lors de l\'insertion : '.$e->getMessage().'</p>';
		}
		//delete achat
		return $result;
	
	}
	
	//Return :List<Achat>
	public function getAchatsByUtilisateur(Utilisateur $utilisateur,$archive = false,$eager = false,$pageStart = -1, $fin = -1) {
	
		$achats = array();
              
                //On recherche les pj ou pas
                $sqlAttachment = ($eager ? " SELECT id FROM attachment WHERE fk_achat= ? " : "");
                
                //Requete achat
		$sql = "SELECT * FROM achat a ";
                          
                //On recherche l'utilisateur
		$sql .= " WHERE fk_utilisateur = '".$utilisateur->getLogin()."'";
		//Affiche ceux qui ne sont pas paye
		$archive ? $sql .= " AND paye = false" : "";              
                
                //On affiche pas ceux supprime
                $sql .= " AND is_deleted = false";
		//Order
		$sql .= " ORDER BY date DESC";
		//Pagination
		($pageStart != -1 && $fin != -1) ? $sql .= " LIMIT ".$pageStart.",".$fin.";" : '';
		
			
		echo (isset($_GET['DEBUG']) ? "<p class='debug'>AchatDbo.GetAchatsByUtilisateur:".$sql." ".$sqlAttachment : "");
		  
		//On affiche que ceux qui ne sont pas paye
		foreach( $this->_pdo->query($sql) as $row ) {
		
			$achat = new Achat(
				$row['prix'],
				$row['date'],
				$utilisateur,
				$row['commentaire'],
				$row['auto']);
				
			$achat->setId($row['id']);
			$achat->setPaye($row['paye']);
			$achat->setDatePaye($row['date_paye']);
                        //Ajout achat en direction de qq si existant
			$row['paye_to'] != "" ?
				$achat->setAchatColocataireAutre($this->data->getInstanceUtilisateur()->getUtilisateur( $row['paye_to'] ))
				: $achat->setAchatColocataireAutre(new Utilisateur());
                        
                        //Ajout piece jointe si demande
                        if ($eager) {
                            $stmt = $this->_pdo->prepare($sqlAttachment);
                            $stmt->bindParam(1, $row['id']);
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
                            foreach ($result as $attachment) {
                                $achat->addAttachment($attachment[0]);
                            }
                        }
                        //Ajout de l'achat a la liste
                        array_push($achats, $achat);
			
		}
		//Retourne un tableau d'utilisateur
		return $achats;
	}
	
	public function getAchatsByGroupe(Groupe $groupe) {
	
		$achats = array();
		$sql = "SELECT * FROM achat 
		INNER JOIN utilisateur ON ( utilisateur.login = achat.fk_utilisateur )
		INNER JOIN groupe ON ( groupe.nom = utilisateur.fk_groupe )
		WHERE groupe.nom = '".$groupe->getNom()."' AND achat.paye=false AND achat.is_deleted = false ";
                echo (isset($_GET['DEBUG']) ? "<p class='debug'>AchatDbo.GetAchatByGroupe:".$sql : "");
		foreach( $this->_pdo->query($sql) as $row ) {
		
			$achat = new Achat($row['prix'],$row['date'],$this->data->getInstanceUtilisateur()->getUtilisateur($row['fk_utilisateur']),$row['commentaire']);
			$achat->setId($row['id']);
			$achat->setPaye($row['paye']);
			$achat->setAchatColocataireAutre($this->data->getInstanceUtilisateur()->getUtilisateur($row['paye_to']));

			array_push($achats , $achat);
			
		}
		
		//Retourne un tableau d'achats
		return $achats;
	}
	
	public function calculerTotalAchatGroupe(Groupe $groupe) {
		$sql = "SELECT SUM(prix) FROM achat 
		INNER JOIN utilisateur ON ( utilisateur.login = achat.fk_utilisateur )
		INNER JOIN groupe ON ( groupe.nom = utilisateur.fk_groupe )
		WHERE groupe.nom = '".$groupe->getNom()."' AND achat.paye=false AND achat.is_deleted = false ";
		echo (isset($_GET['DEBUG']) ? "<p class='debug'>calculerTotalAchatGroupe:".$sql : "");
		$sum = 0;
		$result = $this->_pdo->query($sql);
		foreach( $result as $row ) {
			$sum = $row[0];
		}
		return $sum;
		
	}
	
	//TODO envoi d'un mail lorsque l'on regle la facture
	public function reglerFacture(Groupe $groupe) {
		
		try {
			$sql = "UPDATE achat,utilisateur,groupe 
			SET achat.paye=true, date_paye = 'CURDATE()'
			WHERE utilisateur.login = achat.fk_utilisateur
			AND groupe.nom = utilisateur.fk_groupe
			AND groupe.nom = '".$groupe->getNom()."'";

                        //Envoi des mails
                        $this->envoieMails($groupe);
                        //On passe les achats en reglés
                        //$result = $this->_pdo->exec($sql);
		}
		catch( PDOException $e ) {
			echo '<p class="text-error">Erreur lors de l\'insertion : '.$e->getMessage().'</p>';
		}
		return 0;
	}

	/**
         * Compte le nombre d'achat par utilisateur
         * @param Utilisateur $utilisateur nb achat colocataire
         * @param  boolean $archive si on compte les archive ou non
         * @return type 
         */
	public function countNbAchats(Utilisateur $utilisateur = null,$archive = true) {
		$sql = "SELECT count(*) FROM achat ";
		
		if ($utilisateur != null )
			$sql .= "WHERE fk_utilisateur = '".$utilisateur->getLogin()."' ";
		//On compte pas ceux qui sont paye
                if (!$archive )
                    $sql .= " pay = 0 ";
                
		echo (isset($_GET['DEBUG']) ? "<p class='debug'>CountNbAchat:".$sql : "");


		$cmpt = 0;
		foreach( $this->_pdo->query($sql) as $row ) {
			$cmpt = $row[0];	
		}
		return $cmpt;
	}
        
        /**
         * Creation du mail envoyé aux membres du groupe
         * @param Groupe $groupe 
         */
        //TODO optimiser la fonction d'ecriture des msg
        protected function envoieMails(Groupe $groupe) {
            
            $objet = "Paiement Colocataires";
            $txt = "<p>Bonjour,";
            $txt .= "<p>Ceci est un message de confirmation de regl&eacute;ment pour chaques colocataires";
            $txt .= "<p>R&eacute;capitulatif des achats des colocataires :";
            //Syntese des achats
            $txt .= $this->constructionRecapitulatifAchat($groupe);
            //Calcul des sommes pour chaque coloc
            $groupe->calculGroupe();
            
            foreach ($groupe->getUtilisateurs() as $user) {
                if (count($user->printDetailARembourser()) < 4)
                    continue;
                $txt .= "<p>Le Colocataire ".$user->getLogin();
                $txt .= " doit r&eacute;gler au ".$user->printDetailARembourser();
            }
            
            
            //Envoi des mails
            foreach ($groupe->getUtilisateurs() as $coloc) {
                //Pas de mail associé suivant
                if ($coloc->getMail() == "")
                    continue;
                if (isset($_GET['DEBUG'])) {
                    echo "<p>envoi e-mail:".$coloc->getMail();
                    echo "<p>message:".$txt;
                }
                $mail = new Email($coloc,$txt,$objet);
                //Envoie de l'email
                $mail->sendMail();
               
                
            }
            
        }
        

        /**
         * Creation du message envoyé au colocataire contenant le resume des achats
         * @param Groupe $groupe 
         * @return String txt retourne le tableau du recap des achats 
         */
        protected function constructionRecapitulatifAchat(Groupe $groupe) {
            $txt = "";
            
            $txt .= "<table>";
            //Entete tableau
            $txt .= "<thead>";
                $txt .= "<th>Date</th>";
                $txt .= "<th>Commentaire</th>";
                $txt .= "<th>Prix</th>";
                $txt .= "<th>Colocataire</th>";
            $txt .= "</thead>";
            
            //On recupere tous les achats des utilisateurs
            foreach($groupe->getUtilisateurs() as $coloc) {
                $tot = 0;
                //Affichage du coloc
                $txt .= "<tr><td colspan='4' background-color='gray'>".$coloc->getLogin()."</td></tr>";
                foreach( $achats = $coloc->getAchats() as $achat ) {
                    //Si l'achat est deja paye on l'affiche pas
                    if ($achat->isPaye())
                        continue;
                    $tot += $achat->getPrix();
                    $txt .= "<tr>";
                        $txt .= "<td>".$achat->getDate()."</td>";
                        $txt .= "<td>".$achat->getCommentaire()."</td>";
                        $txt .= "<td>".$achat->getPrix()."</td>";
                        $txt .= "<td>".$achat->getachatColocataireAutre()->getLogin()."</td>";
                    $txt .= "</tr>";
                }
                $txt .= "<tr colspan='2'><td></td><td colspan='2'>Total achat :".$tot."</td></tr>";
            }
            $txt .= "</table>";
            return $txt;
        }
}

?>