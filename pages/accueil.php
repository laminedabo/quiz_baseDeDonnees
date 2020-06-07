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
                    <a class="nav-link <?php if(!isset($_GET['menu']) || $_GET['menu']=='listeQuestions') echo(' active') ?>" href="pages/listeQuestions.php">Liste des questions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($_GET['menu']=='listeJoueurs') echo(' active') ?>" href="pages/listeJoueurs.php">Liste des joueurs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($_GET['menu']=='creerQuestions') echo(' active') ?>" href="pages/creerQuestions.php">Creer une question</a>
                </li>
                <li class="nav-item insc">
                    <a class="nav-link <?php if($_GET['menu']=='inscription') echo(' active') ?>" href="pages/inscription.php">Creer un admin</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Espace Admin</a>
                    <div class="dropdown-menu liste_esp_admin">
                        <a class="dropdown-item" href="#">Link 1</a>
                        <a class="dropdown-item" href="#">Link 2</a>
                        <a class="dropdown-item" href="#">Link 3</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="container float-left col-md-8" id="pageActuAdmin">
        <?php include('listeQuestions.php');?>
    </div>
    <div class="container float-right border  rounded shadow-sm col-md-4 mt-5 ">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Velit repellendus blanditiis neque ad modi aut voluptas ipsum quae doloribus nesciunt, ipsam, obcaecati dolores, sunt non dolor deleniti natus quasi fugiat?</div>
</div>
<?php
?>