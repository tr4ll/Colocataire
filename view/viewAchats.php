<script>
$(document).ready(function() {
	//ligne paire/impaire
	$.tablesorter.defaults.widgets = ['zebra'];
        //init table sorter
	$("table").tablesorter( 
        {
            headers: {
                4: {sorter: false},
                5: {sorter:false},
                6: {sorter:false}}
        });
}); 
</script>
<?php 
$nbElement = NB_PAR_PAGE;
//$nbElement = 25;

//Enregistrement d'un achat
if ( !empty($_POST['prix']) && !empty($_POST['date']) ) {
		$achat = new Achat($_POST['prix'],$_POST['date'],$utilisateurConnecte,$_POST["commentaire"]);
		$achat->setId($_POST["id"]);
		$_POST["coloc"] != "0" ? $achat->setAchatColocataireAutre($data->getInstanceUtilisateur()->getUtilisateur($_POST["coloc"])) : $achat->setAchatColocataireAutre(new Utilisateur(""));
		isset($_POST["partage"]) ? $achat->setPartage(true) : $achat->setPartage(false); 	
		if(isset($_FILES["upload_file"])) $achat->addAttachment($_FILES["upload_file"]);
                $result = $data->getInstanceAchat()->saveAchat($achat);
		
		echo !$result ? "<p class='label label-important'>L'enregistrement &aecute, &eacute;chou&eacute;</p>" : "<p class='label label-success'>Enregistrement r&eacute;ussie</p>";
}

//Archive  Affiche ou non les achats regles
$archive = false;
//suppression d'un achat
$delete = isset($_GET['del']) ? $data->getInstanceAchat()->deleteAchat($_GET['del']) : false;
echo $delete ? "<p class='label label-success'>Suppression effectu&eacute;e</p>" : "";

//Pagination
$pageStart = 0;
$pageEnd = $nbElement;
if (isset($_GET['pageStart']) && isset($_GET['pageEnd'])) {
	$pageStart = $_GET['pageStart'];
	$pageEnd = $_GET['pageEnd'];
}

//TODO : revoir l'appel
//Si on veux voire les achats du coloc
if ( isset($_GET['colocataire']) ) {
	$colocataire = $data->getInstanceUtilisateur()->getUtilisateur($_GET['colocataire']);
	$achats = $data->getInstanceAchat()->getAchatsByUtilisateur($colocataire,true,true,$pageStart,$pageEnd);
	
}
//Sinon on affiche ses propres achats
else {
	//On recherche tous les achat
	$achats = $data->getInstanceAchat()->getAchatsByUtilisateur($utilisateurConnecte,false,true,$pageStart,$pageEnd);
	$utilisateurConnecte->setAchats($achats);
	//On manipule le mm obj
	$colocataire = $utilisateurConnecte;
        $archive = true;
}

?>
<?php
if ($archive) echo
'<label class="checkbox">
      <input type="checkbox" id="chkPayer"> Afficher les achats r&eacute;gl&eacute;
</label>';
?>
<table id="table" class="table table-hover">
<thead>
	<tr>
		<th>Date</th>
		<th>Prix (&euro;)</th>
		<th>Commentaire</th>
		<th>Colocataire</th>
		<?php if ($archive) echo  "<th>R&eacute;gl&eacute;</th>" ?>
		<th>Auto</th>
		<?php if(!isset($_GET['colocataire'])) { ?><th>Actions</th><?php }?>
                <th><i class=" icon-file"</i></th>
	<tr>
</thead>
<tbody>

<?php
$i = 0;
foreach ( $achats as $achat ) {
	//img paye et non paye
	$achat->isPaye() ? $img = "<i class='icon-ok' ></i>" : $img = "<i class='icon-remove-sign' ></i>";
	$achat->isAchatAutomatique() ? $imgAuto = "<i class='icon-ok' ></i>" : $imgAuto = "<i class='icon-remove-sign' ></i>";

	
	$achat->getDatePaye() != null ? $dateP = "title='".$achat->getDatePaye()."'" : $dateP = '';
	
	echo "<tr>";
		echo "<td>".$achat->getDate()."</td>" . "\n";
		echo "<td>".$achat->getPrix()."</td>" . "\n";
		echo "<td>".$achat->getCommentaire()."</td>" . "\n";
		echo "<td>".$achat->getAchatColocataireAutre()->getLogin()."</td>" . "\n";
		if ($archive) echo "<td align='center' ".$dateP.">".$img."</td>" . "\n";
		echo "<td align='center'>".$imgAuto."</td>" . "\n";
		if ( !isset($_GET['colocataire']) ) {
			echo "<td align='center'><a title='Supprimer' id='delete' onClick=\"confirmDelete('index.php?view=viewAchats&del=".$achat->getId()."')\"><i class='icon-remove'></i></a>&nbsp;&nbsp;" . 
                                "<a title='Editer' class='edit' href='index.php?view=createAchat&edit=".$achat->getId()."'><i class='icon-pencil'></i></a></td>" . "\n";;
		}
                echo "<td>";
                foreach ( $achat->getAttachments() as $idAttachment) {
                    echo "<a class='btn' target='_blank' href='view/readFile.php?id={$idAttachment}'><i class='icon-upload'></i></a> ";
                }
                echo "</td>";
	echo "</tr>";
	$i++;
}
?>
</tbody>
</table>
<!-- Pagination TODO
<?php 
//$url = "http://".$_SERVER['HTTP_HOST'];
$prec = $pageStart - $nbElement;
$ptmp = $pageStart;

$pageStart = $pageEnd;
$pageEnd += $nbElement;
$nbAchats = $data->getInstanceAchat()->countNbAchats($colocataire);

echo (isset($_GET["DEBUG"]) ? "Nb achats total :".$nbAchats : "");

echo "<p class='pagination'>";

$disable = "";
if ($prec < 0) $disable = "onclick=\"this.removeAttribute('href');this.className='disabled'\"";
	
echo "<a ".$disable." href='index.php?view=viewAchats&colocataire=".$colocataire->getLogin()."&pageStart=".$prec."&pageEnd=".$ptmp."' > < Page pr&eacute;c&egrave;dante</a> ";

echo round($ptmp / $nbElement)." / ". round($nbAchats / $nbElement);
$disable = "";
if ($pageEnd > $nbAchats + $nbElement) $disable = "onclick=\"this.removeAttribute('href');this.className='disabled'\"";
    
echo " <a ".$disable." href='index.php?view=viewAchats&colocataire=".$colocataire->getLogin()."&pageStart=".$pageStart."&pageEnd=".$pageEnd."' > Page suivante > </a> ";



//Nb element par page
//TODO activer le changement d element par page
/*
echo "<select name='nb_element_page' onchange='changeNbPage()'>";
echo	"<option id='5'>5</option>";
echo	"<option id='15'>15</option>";
echo	"<option id='25'>25</option>";
echo "</select>";
 */
?> -->
<!-- On affiche pas le total des achats si c'est pas nos achats -->
<?php if ( !isset( $_GET['colocataire']) ) {?>
<h4 class="text-info"> Total de mes achats non pay&eacute;s:
<?php echo $utilisateurConnecte->calculerTotalAchatNonPaye() ?> &euro;
</h4>
<?php } ?>