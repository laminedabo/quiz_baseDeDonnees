<?php
	is_connected();
	$prenom = $_SESSION['user']['PRENOM'];
	$nom = strtoupper($_SESSION['user']['NOM']);
	$photo = (isset($_SESSION['user']['image']))?$_SESSION['user']['image']:"./photos/user.png";
?>
<div class="container col-md-8 col-sm-10 col-xs-12 h-100 accueil">
    <div class="pt-4 row header_admin">
        <div class="d-flex  container">
            <div class=" col-2 col-xs-4 text-center  idAdmin"><img class=" photoAdmin" src="<?=$photo?>">
				<div class="text-center"><?php echo $prenom.'<br/>'.$nom;?></div>
            </div>
            <div class="text-center align-self-center col-8 col-xs-4 msg-accueil-adm">
                Administrez votre plateforme de jeux.
            </div>
            <div class="deconnexion col-2 col-xs-4">
                     <?php
                        echo "<a onclick=\"if(!confirm('Vous souhaitez vous déconncter?')){event.preventDefault();}\" href='index.php?statut=logout'><button id='deconnexion'>Déconnexion</button></a>";
                    ?>
            </div>
        </div>
        <div class="container menu d-xs-none">
            <ul class="nav nav-tabs nav-justified   flex-column flex-sm-row">
                <li class="nav-item">
                    <a class="nav-link active" href="pages/listeQuestions.php">Liste des questions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/listeJoueurs.php">Liste des joueurs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/creerQuestions.php">Creer une question</a>
                </li>
                <li class="nav-item insc">
                    <a class="nav-link" href="pages/inscription.php">Creer un admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Espace Admin</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="container float-left col-md-8" id="pageActuAdmin">
        <?php// include('listeQuestions.php');?>
    </div>
    <div class="container float-right border  rounded shadow-sm col-md-4 mt-5 ">Bienvenue sur votre plateforme d'administration de jeu. Si vous double cliquer sur un texte vous pourriez modifier sa valeur si cela est possible avec ce champ. </div>
</div>
<?php
?>

<script>
    window.onload = function() {
        $("#pageActuAdmin").load('pages/listeQuestions.php');
    };
</script>