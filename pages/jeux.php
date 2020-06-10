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
    </div>
    <div class="container text-center mt-3">
            <div class="container repondre col-md-7 col-sm-12 border float-left ">
                <h2>Repondre aux questions</h2>
            </div>
            <div class="container meilleurScr col-md-5 border float-left">
                <h3>Meilleurs Scores</h3>
                <table class="table table-striped">
                    <thead>
                        <tr class="text-center">
                            <th>Prenoms</th>
                            <th>Noms</th>
                            <th>Scores</th>
                        </tr>
                    </thead>
                    <tbody id="tMeilleursScr">
                        <!-- ici la liste des cinq meilleurs joueurs -->
                    </tbody>
                </table>
            </div>            
    </div>
</div>
<?php
// print_r($_SESSION);
?>