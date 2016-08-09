<div class="navbar navbar-inverse">
    <div class="navbar-inner">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">Colocataire</a>
          <div class="nav-collapse collapse">
            <ul class="nav">

                <?php if ($utilisateurConnecte->getLogin() == "admin") { ?>
                <!-- Menu Admin -->
                <li><a href="index.php?view=viewUtilisateurs">Voir les utilisateurs</a></li>

                <li>
                <a href="index.php?view=viewGroupes">Voir les groupes</a>
                </li>
                <?php } ?>
                <?php if ($utilisateurConnecte->getLogin() != "admin") { ?>
                <!-- Menu utilisateur -->
                <li><a href="index.php?view=viewUtilisateursGroupe">Mes Colloc's</a></li>

                <li><a href="index.php?view=viewAchats">Mes Achats</a></li>

                <li><a href="index.php?view=createAchat">Ajouter Achat</a></li>

                <li><a href="index.php?view=viewEventAchat">Achats r&eacute;guli&eacute;s</a></li>
                <?php } ?>

            </ul>
          </div>
    </div>
</div>