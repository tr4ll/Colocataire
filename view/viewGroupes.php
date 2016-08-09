<a href="index.php?view=createGroupe">Ajouter un nouveau groupe</a>

<table id="table" class="table table-hover">
<thead>
	<tr>
		<th>Nom Groupe</th>
		<th colspan="2" width="10%">Action</th>
	<tr>
</thead>
<?php
//Enregistrement d'un groupe
if ( !empty($_POST['groupe']) ) {
		$groupe = new Groupe($_POST['groupe']);
		$result = $data->getInstanceGroupe()->saveGroupe($groupe);
		
		echo !$result ? "<p class='label label-important'>L'enregistrement &agrave; &eacute;chou&eacute;</p>" : "<p class='text-success'>Enregistrement r&eacute;ussie</p>";
}

//On instancie la classe de transaction avec la BDD
//suppression d'un utilisateur
$delete = isset($_GET['del']) ? $data->getInstanceGroupe()->deleteGroupe($_GET['del']) : false;
echo $delete ? "<p class='label label-success'>Suppression effectu&eacute;e</p>" : "";

//On recherche tous les groupes
$groupes = $data->getInstanceGroupe()->getGroupes();


foreach ( $groupes as $groupe ) {
	
	echo "<tr>";
		echo "<td>".$groupe->getNom()."</td>";
		echo "<td class='delete'><a href='index.php?view=viewUtilisateurs&del=".$groupe->getNom()."'></a></td>";
		echo "<td class='edit'><a href='index.php?view=createUtilisateur&edit=".$groupe->getNom()."'></a></td>";
	echo "</tr>";
	

}
?>
</table>

