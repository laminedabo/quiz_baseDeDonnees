<?php
    require_once('../data/requetes.php');
	if (isset($_POST['type'])) {
        if($_POST['type'] == 'connexion'){
            $result = connexion($_POST['login'],$_POST['password']);
        }
        elseif($_POST['type'] == 'inscription'){
            $result =  addUser($_POST['prenom'],$_POST['nom'],$_POST['login'],$_POST['password']);
        }
        echo  $result;
    }
    elseif(isset($_POST['liste'])){
        if($_POST['liste'] == "joueur"){
            echo listeJoueur($_POST['limit'],$_POST['offset']);
        }
    }
	else{
		echo 'no';
	}
?>