<script>

    function openDiv() {
 
      // run the effect
      $( "#achat_autre" ).toggle( 'blind', 1000 );
    };

</script>
<?php 
$achat = new Achat();
isset ($_GET['edit']) ? $achat = $data->getInstanceAchat()->getAchat($_GET['edit']) : "";
$utilisateur = new Utilisateur();
isset ($_GET['utilisateur']) ? $utilisateur = $data->getInstanceUtilisateur()->getUtilisateur($_GET['utilisateur']) : "";
$groupe = $data->getInstanceGroupe()->getGroupe( $utilisateurConnecte->getGroupe()->getNom(), true );

?>
<form method="POST" action="index.php?view=viewAchats" enctype="multipart/form-data">
        <p><div class="input-prepend">
            <span class="add-on">€</span>
            <input class="span2" type="number" min="0" max="9999" step="0.01" name="prix" value="<?php echo $achat->getPrix(false)?>" required />
        </div>
        <p><div class="input-prepend">
            <span class="add-on"><i class="icon-calendar"></i></span>
            <input class="span2" name="date" id="date" type="text" value="<?php echo $achat->getDate()?>" required >
        </div>
        <p><div class="input-prepend">
            <span class="add-on"><i class="icon-user"></i></span>
            <select class="span2" name="coloc">
                <?php 
                echo '<option value="0">Achat Commun</option>';
                foreach ($groupe->getUtilisateurs() as $colocataire)
                {
                        $select = "";
                        if($achat->getAchatColocataireAutre() != "")
                                if ($achat->getAchatColocataireAutre()->getLogin() == $colocataire->getLogin())
                                        $select = "selected";
                        if ( $colocataire->getLogin() != $utilisateurConnecte->getLogin() )
                            echo "<option value='".$colocataire->getLogin()."' ".$select.">".$colocataire->getLogin()."</option>";
                }
                ?>
            </select>
        </div>
	<p><textarea rows="8" name="commentaire" > <?php if($achat->getCommentaire()!="") echo $achat->getCommentaire(); ?> </textarea>
        <p><input name="upload_file" id="upload_file" type="file" value="<?php echo $achat->getAttachment(0)?>"  >
        
	<input type="hidden" name="id" value="<?php echo $achat->getId()?>" />	
	<p><input class="btn" type="submit" value="Enregistrer" />
</form>