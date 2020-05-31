<?php
	$msg_erreur = '';
	//recuperation des infos de connexion
	if (isset($_POST['submit'])) {
		if (!empty($_POST['login']) && !empty($_POST['pass'])) {
			$login = trim($_POST['login']);
			$pass = trim($_POST['pass']);
			if (($result = connexion($login,$pass))=='error') {
				$msg_erreur = "<span id='msg_erreur'>login ou mot de pass incorrect.</span>";
			}
			else{
				header('location:index.php?user='.$result);
			}
		}
		else{
			$msg_erreur = "<span id='msg_erreur'>donnez le login et le mot de pass svp.</span>";
		}
	}
	else{
		$msg_erreur = "<span id='msg_erreur'>veillez vous identifier.</span>";
	}
	if (isset($msg_erreur)) {
		echo $msg_erreur;
	}
?>


<div class="container col-md-6 col-sm-12 col-xs-12 pageConnect">
      <div class="col-md-12 loginform">Login Form</div>
      <div class="col-md-12 rounded-bottom form_container">
        <form method="POST" action="" class="myform" id="form_connexion">
          <div class="form-group">
            <input type="text" name="login" class="form-control" id="login" placeholder="Login" error="error1" autofocus="">
            <small  class="form-text text-muted error_form" id="error1"></small>
          </div>
          <div class="form-group">
            <input type="password" name="pass" class="form-control" id="password" placeholder="password" error="error2">
            <small  class="form-text text-muted error_form" id="error2"></small>
          </div>
          <button type="submit" name="submit" class="btn btn-primary btn_connexion">Connexion</button>
          <a id="sinscrire" href="index.php?inscrire=inscription.php">S'inscrire pour jouer?</a>
        </form>
      </div>
</div>