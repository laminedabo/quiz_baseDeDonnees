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
    if(isset($_POST['liste'])){
        if($_POST['liste'] == "joueur"){
            echo listeJoueur($_POST['limit'],$_POST['offset']);
        }
    }
	if (isset($_POST['update'])) {
        echo update_partial($_POST['table'],$_POST['id'],$_POST['val'],$_POST['champ']);
        // print_r ($_POST);
    }
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'Bloquer') {
            echo bloqueUser($_POST['table'],$_POST['id']);
        }
        else {
            echo 'suppression';
        }
    }
?>