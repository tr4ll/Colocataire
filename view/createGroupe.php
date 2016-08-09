
<?php isset ($_GET['edit']) ? $groupe = $data->getInstanceGroupe()->getGroupe($_GET['edit']) : $groupe = new Groupe(""); ?>
<form method="POST" action="index.php?view=viewGroupes">
	<p><label >Nom du Groupe : </label><input type="text" name="groupe" value="<?php echo $groupe->getNom()?>" required/>
	<p><input type="submit" value="Enregistrer" />
</form>