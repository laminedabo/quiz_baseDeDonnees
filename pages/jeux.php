<?php
	is_connected();
	$prenom = $_SESSION['user']['PRENOM'];
	$nom = strtoupper($_SESSION['user']['NOM']);
	$photo = (isset($_SESSION['user']['image']))?$_SESSION['user']['image']:"./photos/user.png";
?>
<div class="container col-md-8 col-sm-10 col-xs-12 accueil">
    <div class="pt-4 row header_admin">
        <div class="d-flex container">
            <div class=" idAdmin"><img class=" photoAdmin" src="<?=$photo?>">
				<div class="text-center" id="nom"><?php echo $prenom.'<br/>'.$nom;?></div>
            </div>
            <div class="text-center align-self-center msg-accueil-adm">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quidem tempora deserunt id harum asperiores voluptatum excepturi laborum distinctio dolore doloribus.
            </div>
            <div class=" deconnexion">
                     <?php
                        echo "<a onclick=\"if(!confirm('Vous souhaitez vous déconncter?')){event.preventDefault();}\" href='index.php?statut=logout'><button id='deconnexion'>Déconnexion</button></a>";
                    ?>
            </div>
        </div>
        <div class="container menu">
            <ul class="nav nav-tabs nav-justified">
                <li class="nav-item">
                <a class="nav-link jouer <?php if(!isset($_GET['menu']) || $_GET['menu']=='listeQuestions') echo(' active') ?>" href="llll">Repondre aux questions</a>
                </li>
                <li class="nav-item">
                <a class="nav-link meilleursScores <?php if($_GET['menu']=='listeJoueurs') echo(' active') ?>" href="lll">Meilleurs Scores</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="container" id="pageActuAdmin">
    </div>
</div>
<?php
// print_r($_SESSION);
?>