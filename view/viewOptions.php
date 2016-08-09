<?php 

if (isset($_POST['password']) && isset($_POST['passwordconf'])) {
	if ($_POST['password'] == $_POST['passwordconf']) {
		$utilisateurConnecte->setMdp($_POST['password']);
		$data->getInstanceUtilisateur()->saveUtilisateur($utilisateurConnecte);
	}
}

?>

<form method="POST" action="index.php?view=viewOptions">
<p><label for="loginL">Changer Mot de passe :</label><input type="password" name="password" required />
<p><label for="loginL">Confirmer Mot de passe :</label><input type="password" name="passwordconf" required /><input type="submit" value="sauvegarder"/>
</form>