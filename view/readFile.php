<?php
set_include_path("/var/www/colocataire/");
/*
Definition des entetes
*/
//Variable global
require_once "dbo/db.php";

//instanciation de la connection
$data= new DataAccess();
/**
 * Page de gestion de l'affichage des pieces jointes
 */
if (isset($_GET['id'])) {
    
    $file = $data->getInstanceFileFromDb();
    $file->setIdFichier($_GET['id']);
    $file->writeOutput();
}
?>
