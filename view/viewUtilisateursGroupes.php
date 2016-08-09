
<?php 
//Les collocataire regle leurs parts
if (isset($_GET["regler"])) 
//On passe tous les dernier achat a true
	$data->getInstanceAchat()->reglerFacture($utilisateurConnecte->getGroupe());
?>
<table id="table" class="table table-hover">
<thead>
	<tr>
		<th>Nom utilisateur</th>
		<th>Total Pay&eacute;e (&euro;)</th>
		<th>Total a payer (&euro;)</th>
	<tr>
</thead> 
<tbody>
<?php
//FIXED BUG : on recharge tt les objets car sinon on est obliger de raffraichir la session
//$groupe = $utilisateurConnecte->getGroupe();
$groupe = $data->getInstanceGroupe()->getUtilisateur($utilisateurConnecte->getLogin(),true)->getGroupe();
//On lance le calcul pour connaitre les sommes du de chaque utilisateur
$groupe->calculGroupe();
$i = 0;
foreach ( $groupe->getUtilisateurs() as $utilisateur ) {
	//Color ligne
	$i%2 ? $ligne = "class='ligne-colour'" : $ligne = "";
	
	$url = "http://".$_SERVER['HTTP_HOST']."/colocataire/index.php?view=viewAchats&colocataire=".$utilisateur->getLogin(); 
	echo "<tr onClick=\" window.location ='".$url."'\" ".$ligne." title='Afficher les achats en cours'>";
		echo "<td>".$utilisateur->getLogin()."</td>";		
		echo "<td>".$utilisateur->calculerTotalAchatNonPaye(true)."</td>";
		echo "<td>".$utilisateur->printDetailARembourser()."</td>";
	echo "</tr>";
	
$i++;
}
?>
</tbody>
</table>
<?php echo "<h5 class='text-info'>Moyenne des achats du groupe : ".$groupe->calculerMoyenne()." &euro;</h5>"; ?>

<a title="Permet de mettre les compteurs &agrave; zero" class="btn btn-small" href="index.php?view=viewUtilisateursGroupe" onclick="confirmReglementAchat('index.php?view=viewUtilisateursGroupe&regler=true')"><i class="icon-envelope"></i> R&eacute;gler les sommes dues</i></a>

