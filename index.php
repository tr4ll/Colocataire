<?php

set_include_path("/var/www/colocataire/");
/*
Definition des entetes
*/
//Variable global
require_once "dbo/db.php";

//Demarrage de la seesion
session_start();
session_set_cookie_params(604800);
ini_set('session.gc_maxlifetime', 30*60);

//Navigation entre les pages
require_once "view/view.php";
//instanciation de la connection
$data= new DataAccess();
//Skin par default utilisateur
$_SESSION['SKIN'] = 'skin1.css';
?>
<!DOCTYPE html>
<html>
<head>
<!-- Fichoer CSS Default
<link rel='stylesheet' href='css/960.css' type='text/css' media="screen" charset="utf-8"/>
<link rel='stylesheet' href='css/default.css' type='text/css' media="screen" charset="utf-8"/>
<link rel='stylesheet' href='css/colour.css' type='text/css' media="screen" charset="utf-8"/>
<link rel='stylesheet' href='css/text.css' type='text/css' media="screen" charset="utf-8"/>-->

<link rel="stylesheet" href='css/jquery-ui-1.10.3.custom.min.css' />
<link rel='stylesheet' href='css/bootstrap.css' type='text/css' media="screen" charset="utf-8"/>
<link rel='stylesheet' href='css/bootstrap-responsive.css' type='text/css' media="screen" charset="utf-8"/>
<link rel='stylesheet' href='css/style.css' type='text/css' media="screen" charset="utf-8"/>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<!-- Fichoer CSS Perso
<link rel='stylesheet' href='css/<?php echo $_SESSION['SKIN']; ?>' type='text/css' />
-->

<!-- Def language -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="title" content="Colocataire" />
<meta name="description" content="Utilitaire de gestion d'argent entre colocataires" />
<meta name="keywords" content="paiement entre colocataires" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Script Javascript -->
<script src="http://code.jquery.com/jquery.js"></script>
<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
<script src="script/jquery.tablesorter.min.js"></script>
<script src="script/bootstrap.js"></script>
<!-- dialogue box pour supprimer un element -->
<script>

$( "#dialog-confirm" ).dialog({ autoOpen: false });

function confirmDelete(url) {

				$( "#dialog-confirm" ).dialog({
						  resizable: false,
						  height:200,
						  width:300,
						  modal: true,
                                                  
						  buttons: {
							"Supprimer": function() {
							  $( this ).dialog( "close" );
							  window.location = url;
                                              
							},
							Cancel: function() {
							  $( this ).dialog( "close" );
                                                   
							  return false;
							}
						  }
						});
 
}
<!-- dialogue box pour supprimer un element -->
$( "#dialog-confirm" ).dialog({ autoOpen: false });

function confirmReglementAchat(url) {

				$( "#dialog-confirm-achat" ).dialog({
						  resizable: false,
						  height:200,
						  width:300,
						  modal: true,
						  buttons: {
							"Régler": function() {
							  $( this ).dialog( "close" );
							  window.location = url;
							},
							Cancel: function() {
							  $( this ).dialog( "close" );
							  return false;
							}
						  }
						});
 
}
</script>
  
  <!-- ToolTip Jquery -->
  <script>
  $(function() {
    $( document ).tooltip({
      position: {
        my: "center bottom-20",
        at: "center top",
        using: function( position, feedback ) {
          $( this ).css( position );
          $( "<div>" )
            .addClass( "arrow" )
            .addClass( feedback.vertical )
            .addClass( feedback.horizontal )
            .appendTo( this );
        }
      }
    });
  });
  </script>
  
  <script>
    $.datepicker.setDefaults( $.datepicker.regional[ "fr" ] );
    $(function() {
      $( "#date" ).datepicker({ 
          dateFormat: "yy-mm-dd"
      });
    });
</script>
</head>
<body>
<header>
<!-- Entete de la page -->
	<?php require_once "view/entete.php"; ?> 
</header>
<!-- Structure corp de la page -->
<nav>
<?php if (isset($utilisateurConnecte)) { ?>
<!-- Barre de navigation -->
	<?php require_once "view/nav.php"; ?>
<?php } ?>
</nav>

<section>
<div class="container">

<!-- Page de contenu -->
	<?php include $view; ?>
</div>
<!-- en mode debug -->
<div id="debug"></div>
</section>
<footer>
  
<div>
	<?php require_once "view/foot.php"; ?>
</div>
   
</footer>
<!--ToolTipDialog ondelete-->
<div id="dialog-confirm" title="Supprimer l'&eacute;l&eacute;ment" style="width: 120px;height:120px;display:none;" >
  <p><span style="height:100px">Cet enregistrement va etre supprim&eacute;</span></p>
</div>
<!--ToolTipDialog ondelete-->
<div id="dialog-confirm-achat" title="R&eacute;gler les achats" style="width: 120px;height:120px;display:none;" >
    <p><span style="height:100px">Les achats vont &ecirc;tre r&eacute;gl&eacute;s</span></p>
</div>
</body>
</html>