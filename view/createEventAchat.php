<?php 
$eventAchat = new EventAchat('','','','',$utilisateurConnecte);
isset ($_GET['edit']) ? $eventAchat = $data->getInstanceEventAchat()->getEventAchat($_GET['edit']) : "";

?>

<form method="POST" action="index.php?view=viewEventAchat">
        <p><div class="input-prepend">
            <span class="add-on">€</span>
            <input class="span2" type="number" min="0" max="9999" step="0.01" name="prix" value="<?php echo $eventAchat->getPrix()?>" required />
        </div>
        <p><div class="input-prepend">
            <span class="add-on"><i class="icon-tag"></i></span>
            <input class="span2" type="text" name="nom" value="<?php echo $eventAchat->getNom(); ?>" required />
        </div>
        <p><label class="control-label" for="date">Date de d&eacute;but :</label>
        <div class="input-prepend">
            <span class="add-on"><i class="icon-calendar"></i></span>
            <input class="span2" id="date" type="text" value="<?php echo $eventAchat->getDateDebut(); ?>">
        </div>
        <p><div class="input-prepend">
            <span class="add-on"><i class="icon-tasks"></i></span>
            <select class="span2" name="frequence">
		<option value="DAY">jour</option>
		<option value="WEEK">semaine</option>
		<option value="MONTH" selected >mois</option>
		<option value="YEAR">ann&eacute;e</option>
            </select>
        </div>
	<p><textarea rows="10" cols="70" name="commentaire" ><?php echo $eventAchat->getCommentaire(); ?></textarea>
	<p><input class="btn" type="submit" value="Enregistrer" />
</form>