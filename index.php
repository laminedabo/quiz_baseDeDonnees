<!doctype html>
<html lang="en">
  <head>
    <title>mimi projet Quizz SA</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" type="image/png" sizes="96x96" href="./public/images/favicon-96x96.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
  </head>
  <body>
  <div id="titre">
		<img alt="icone quiz"  id="icone-titre" src="public/images/logo-QuizzSA.png">
		<div id="lePlaisirDeJouer">Le plaisir de jouer</div>
	</div>



<?php
		session_start();
		require_once ('traitement/fonctions.php');
		require_once ('data/requetes.php');
		if (isset($_GET['user'])) {
			switch ($_GET['user']) {
				case 'admin':
					require_once('./pages/accueil.php');
					break;

				case 'joueur':
					require_once('./pages/jeux.php');
					break;
				default :
					require_once('./pages/connexion.php');
					break;
			}
		}
		elseif (isset($_GET['inscrire']) || isset($_GET['img'])) {
			require_once('./pages/inscription.php');
		}
		else{
			require_once('./pages/connexion.php');
		}
		
		if (isset($_GET['statut']) && $_GET['statut']==='logout') {
			deconnexion();
		}
	?>



























      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="public/js/script.js">
    </script>
  </body>
</html>