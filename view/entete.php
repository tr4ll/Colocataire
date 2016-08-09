<?php 
if (!empty($_GET['disconnection'])) 
	unset($_SESSION['COLLOCCONNECTED']);


if (isset($_SESSION['COLLOCCONNECTED'])) {
		$utilisateurConnecte = unserialize($_SESSION['COLLOCCONNECTED']);
		echo "<p class='text-right text-muted' id='head' >Bonjour <a href='index.php?view=viewOptions' >".$utilisateurConnecte->getLogin()."</a>";
		echo " <a class='login' href='index.php?view=connection&disconnection=true' >(se d&eacute;connecter)</a></p>";
	}
else
	//echo "<p id='head' align='right'><a class='login' href='index.php?view=connection'>Se connecter</a>";
	
	?>