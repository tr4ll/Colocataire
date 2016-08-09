<?php 

//Enregistrement d'un evenement achat
if ( !empty($_POST['prix']) && !empty($_POST['nom']) && !empty($_POST['frequence'])) {
		$eventAchat = new EventAchat($_POST['nom'],$_POST['prix'],$_POST['frequence'],$_POST['date'],$utilisateurConnecte);
		$eventAchat->setCommentaire($_POST['commentaire']);

		//Sauvegarde de l'evenement en bdd + creation de la procedure
		$result = $data->getInstanceEventAchat()->saveEventAchat($eventAchat);
		
		
		echo !$result ? "<p class='label label-important'>L'enregistrement &agrave; &eacute;chou&eacute;</p>" : "<p class='label label-success'>Enregistrement r&eacute;ussie</p>";
}
?>
<p><a href="index.php?view=createEventAchat" class="btn btn-primary" > Ajouter un &eacute;v&eacute;nement</a>
<table id="table" class="table table-hover">
<thead>
	<tr>
		<th>Nom evenement</th>
		<th>Prix (&euro;)</th>
		<th>Frequence</th>
		<th>Commentaire</th>
		<th colspan="2" width="10%">Actions</th>
	<tr>
</thead>
<tbody>
<?php


//suppression d'un event
$delete = isset($_GET['del']) ? $data->getInstanceEventAchat()->deleteEventAchat($_GET['del']) : false;
echo $delete ? "<p class='label label-success'>Suppression effectu&eacute;e</p>" : "";

//Lecture de tous les event de l'utilisateur
$result = $data->getInstanceEventAchat()->getEventAchatsByUtilisateur($utilisateurConnecte);

foreach ( $result as $eventAchat ) {
	
	echo "<tr>";
		echo "<td>".$eventAchat->getNom()."</td>";
		echo "<td>".$eventAchat->getPrix()."</td>";
		echo "<td>".$eventAchat->getFrequence()."</td>";
		echo "<td>".$eventAchat->getCommentaire()."</td>";
		echo "<td><a  id='delete' class='delete' onClick=\"confirmDelete('index.php?view=viewEventAchat&del=".$eventAchat->getNom()."')\" ><i class='icon-remove'></i></a>";
		echo "&nbsp;&nbsp;<a class='edit' href='index.php?view=createEventAchat&edit=".$eventAchat->getNom()."'><i class='icon-pencil'></i></a></td>";
		
	echo "</tr>";
}


?>
</tbody>
</table>
