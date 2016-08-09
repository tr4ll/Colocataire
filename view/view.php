<?php

//Navigation interpage
//Bug expiration de session
$view = 'view/accueil.php';
if (isset($_SESSION['COLLOCCONNECTED'])) {
    $tabView = array ( 
            'viewUtilisateurs' => "view/viewUtilisateurs.php",
            'viewAchats' => "view/viewAchats.php",
            'createAchat' => "view/createAchat.php",
            'createUtilisateur' => "view/createUtilisateur.php",
            'connection' => "view/connection.php",
            'viewUtilisateursGroupe' => "view/viewUtilisateursGroupes.php",
            'viewGroupes' => "view/viewGroupes.php",
            'createGroupe' => "view/createGroupe.php",
            'viewOptions' => "view/viewOptions.php",
            'viewEventAchat' => "view/viewEventAchat.php",
            'createEventAchat' => "view/createEventAchat.php",
            'readFile' => "view/readFile.php",
    );
}
else {
    $tabView = array ('connection' => "view/connection.php");
    $view = 'view/connection.php';
}

if(!empty($_GET['view']) && array_key_exists($_GET['view'],$tabView))
	$view = $tabView[$_GET['view']];
	
?>