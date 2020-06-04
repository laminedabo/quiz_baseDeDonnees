<?php
    require_once('../data/requetes.php');
	if (isset($_POST)) {
        $res =  connexion($_POST['login'],$_POST['password']);
        echo $res;
	}
	else{
		echo 0;
	}
?>