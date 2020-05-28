<!doctype html>
<html lang="en">
  <head>
    <title>mimi projet Quizz SA</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" type="image/png" sizes="96x96" href="./public/images/favicon-96x96.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
  </head>
  <body>
    <div class="col-md-4 container pageConnect">
      <div class="col-md-12 loginform">Login Form</div>
      <div class="col-md-12 rounded-bottom form_container">
        <form class="myform" id="form_connexion">
          <div class="form-group">
            <input type="text" class="form-control" id="login" placeholder="Login" error="error1" autofocus="">
            <small  class="form-text text-muted error_form" id="error1"></small>
          </div>
          <div class="form-group">
            <input type="password" class="form-control" id="password" placeholder="password" error="error2">
            <small  class="form-text text-muted error_form" id="error2"></small>
          </div>
          <button type="submit" class="btn btn-primary btn_connexion">Submit</button>
          <a id="sinscrire" href="index.php?inscrire=inscription.php">S'inscrire pour jouer?</a>
        </form>
      </div>
   </div>


































      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="public/js/script.js">
    </script>
  </body>
</html>