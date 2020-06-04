<?php
    require_once('../data/requetes.php');
	if (isset($_POST)) {
        if($_POST['type'] == 'connexion'){
            $result = connexion($_POST['login'],$_POST['password']);
        }
        elseif($_POST['type'] == 'inscription'){
            $result =  addUser($_POST['prenom'],$_POST['nom'],$_POST['login'],$_POST['password']);
        }
        echo  $result;
	}
	else{
		echo 0;
	}
?>