<?php 
$utilisateur = new Utilisateur("","",new Groupe(""));
if (isset ($_GET['edit']))
		$utilisateur = $data->getInstanceUtilisateur()->getUtilisateur($_GET['edit']);
	//On recherche tous les modeles
$groupes = $data->getInstanceGroupe()->getGroupes();
?>
<form method="POST" action="index.php?view=viewUtilisateurs">
	<p><label >Nom : </label><input type="text" name="login" value="<?php echo $utilisateur->getLogin()?>" required/>
	<p><label >Mot de passe : </label><input type="password" name="mdp"  required/>
	<p><label >E-Mail : </label><input type="email" name="mail" value="<?php echo $utilisateur->getMail()?>"/>
	<p><label >Groupe : </label>
	<p><select name="groupe">
		<option value="">-----S&eacute;lection-----</option>
	<?php 
	foreach ( $groupes as $groupe ) {
		$selected = "";
		if ( $utilisateur->getGroupe() != "" )
			if ( $utilisateur->getGroupe()->getNom() == $groupe->getNom() )
				$selected = "selected" ;
		
		echo "<option ".$selected." value='".$groupe->getNom()."'>".$groupe->getNom()."</option>";
	}
	?>
	</select>
	<p><input type="submit" value="Enregistrer" />
</form>