<div class="container pageInscription p-2  col-md-6" style="background-color:white;">
  <div class="container">
    <form method="POST" action="" class="myform" id="form_inscription">
          <div class="form-group">
            <input type="text" name="prenom" class="form-control" id="prenom" placeholder="Prenom" error="Prenom" autofocus="">
            <small  class="form-text text-muted error_form" id="Prenom"></small>
          </div>
          <div class="form-group">
            <input type="text" name="nom" class="form-control" id="nom" placeholder="Nom" error="Nom" autofocus="">
            <small  class="form-text text-muted error_form" id="Nom"></small>
          </div>
          <div class="form-group">
            <input type="text" name="login" class="form-control" id="login" placeholder="Login" error="Login" autofocus="">
            <small  class="form-text text-muted error_form" id="Login"></small>
          </div>
          <div class="form-group">
            <input type="password" name="password" class="form-control" id="password" placeholder="password" error="Mot de passe">
            <small  class="form-text text-muted error_form" id="Mot de passe"></small>
          </div>
          <input type="hidden" name="type" value="inscription">
          <button type="submit" name="btn_inscription" class="btn btn-primary btn_connexion" id="btn_inscription">Creer le compte</button>
          <a id="sinscrire" href="index.php?inscrire=inscription.php">S'inscrire pour jouer?</a>
    </form>
  </div>
</div>