<?php
//Test connection
$wrongLogin = false;
if (isset($_POST['login']) && isset($_POST['password'])) {
	//Acces donn&eacute;e bdd
	//Mode eager pour la recup des donn�e
        //Fixed bug : on charge pas tt les donnee ds la session sinon on raffraichi pas les totaux des dues
	$utilisateurConnecte = $data->getInstanceUtilisateur()->getUtilisateur($_POST['login']);
	
	if($utilisateurConnecte->getMdp() == md5($_POST['password'])) {
		echo "<p class='label label-success'>Connection r&eacute;ussie</p>";
		//On enregistre l'utilisateur en session
		$_SESSION['COLLOCCONNECTED'] = serialize($utilisateurConnecte);
		header('Location: index.php');
	} else $wrongLogin = true;
	
		
}
		

?>

    <form class="form-signin" method="POST">
        <h2 class="form-signin-heading">Veuillez entrez vos identifiants</h2>
        <input type="text" name="login" class="input-block-level" placeholder="Identifiant" required />
        <input type="password" name="password" class="input-block-level" placeholder="Password" required />
        <?php if($wrongLogin)  echo  "<div class='alert alert-error'>Login ou mot de passe &eacute;ronn&eacute;</div>"; ?>
        <button class="btn btn-large btn-primary" type="submit">connection</button>
    </form>
