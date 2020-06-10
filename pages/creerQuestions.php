

<div class="container col-md-12 pageConnect">
      <div class="col-md-12 loginform">Creer une question</div>
      <div class="col-md-12 rounded-bottom form_container">
        <form method="POST" action="" class="myform" id="form_inscription">
			<div class="form-group">
				<label for="question" class="col-2 col-form-label">Question</label>
				<input type="text" name="question" class="form-control" id="question" error="Champ">
				<small  class="form-text text-muted error_form" id="Champ"></small>
			</div>
			<div class="form-group">
				<label for="nbPoint" class="col-2 col-form-label">Points</label>
				<div class="col-10">
					<input class="form-control" type="number" min="1" value="1" id="nbPoint">
				</div>
			</div>
			<select class="form-control col-8 d-inline">
				<option selected="" value="">Choisissez le type de reponse</option>
				<option value="choix_multiple">Choix multiple</option>
				<option value="choix_simple">Choix simple</option>
				<option value="reponse_texte">Reponse texte</option>
			</select>
			<button type="button" hidden="" id="btn_nvlle_rep"></button>
			<label for="btn_nvlle_rep" id="btn_nvlle_rep"><img src="./public/images/icones/ic-ajout-réponse.png"></label>
		    <input type="hidden" name="type" value="creer_question">
             <button type="submit" name="nvlleqst" class="btn btn-primary btn_connexion d-block" id="btn_nvelleqst">Enregistrer</button>
        </form>
      </div>
</div>


<?php
	// ajoutQuestion();
?>
<script>
	
    $("#btn_nvlle_rep").click(function(){
        alert('clck');
    })
</script>