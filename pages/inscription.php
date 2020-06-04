<p>hello add admin here</p>

       <div class="container col-md-6">
       <form method="POST" action="" class="myform" id="form_inscription">
          <div class="form-group">
            <input type="text" name="prenom" class="form-control" id="login" placeholder="Prenom" error="error1" autofocus="">
            <small  class="form-text text-muted error_form" id="error1"></small>
          </div>
          <div class="form-group">
            <input type="text" name="nom" class="form-control" id="login" placeholder="Nom" error="error1" autofocus="">
            <small  class="form-text text-muted error_form" id="error1"></small>
          </div>
          <div class="form-group">
            <input type="text" name="login" class="form-control" id="login" placeholder="Login" error="error1" autofocus="">
            <small  class="form-text text-muted error_form" id="error1"></small>
          </div>
          <div class="form-group">
            <input type="password" name="pass" class="form-control" id="password" placeholder="password" error="error2">
            <small  class="form-text text-muted error_form" id="error2"></small>
          </div>
          <button type="submit" name="btn_inscription" class="btn btn-primary btn_connexion" id="btn_inscription">Creer le compte</button>
          <a id="sinscrire" href="index.php?inscrire=inscription.php">S'inscrire pour jouer?</a>
        </form>
       </div>