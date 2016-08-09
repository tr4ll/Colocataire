<a href="index.php?view=createUtilisateur">Ajouter un nouvel utilisateur</a>

<table id="table" class="table table-hover">
<thead>
	<tr>
		<th>Nom</th>
		<th>Groupe</th>
		<th>Total Pay&eacute;e</th>
		<th colspan="2" width="10%">Action</th>
	<tr>
</thead>
<?php
//Enregistrement d'un utilisateur
if ( !empty($_POST['login']) && !empty($_POST['mdp']) && !empty($_POST['groupe']) ) {
		//on instancie un nouvel utilisateur
		$utilisateur = new Utilisateur($_POST['login'],$_POST['mdp'],$data->getInstanceGroupe()->getGroupe($_POST['groupe']));
		$utilisateur->setMail($_POST['mail']);
		
		$result = $data->getInstanceUtilisateur()->saveUtilisateur($utilisateur);
		
		echo !$result ? "<p class='label label-important'>L'enregistrement &agrave; &eacute;chou&eacute;" : "<p class='text-success'>Enregistrement r&eacute;ussie";
}

//On instancie la classe de transaction avec la BDD
//suppression d'un utilisateur
$delete = isset($_GET['del']) ? $data->getInstanceUtilisateur()->deleteUtilisateur($_GET['del']) : false;
echo $delete ? "<p class='label label-success'>Suppression effectu&eacute;e" : "";

//On recherche tous les utilisateurs
$utilisateurs = $data->getInstanceUtilisateur()->getUtilisateurs();


foreach ( $utilisateurs as $utilisateur ) {
	//Ajoute les achats au utilisateurs
	$utilisateur->setAchats($data->getInstanceAchat()->getAchatsByUtilisateur($utilisateur));
		
	echo "<tr>";
		echo "<td>".$utilisateur->getLogin()."</td>";
		echo "<td>".$utilisateur->getGroupe()->getNom()."</td>";
		echo "<td>".$utilisateur->calculerTotalAchatNonPaye()."</td>";
		echo "<td class='delete'><a href='index.php?view=viewUtilisateurs&del=".$utilisateur->getLogin()."'></a></td>";
		echo "<td class='edit'><a href='index.php?view=createUtilisateur&edit=".$utilisateur->getLogin()."'></a></td>";
	echo "</tr>";
	

}
?>
</table>

