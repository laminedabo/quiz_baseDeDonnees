

<div class="container col-md-12 pageConnect">
      <div class="col-md-12 loginform">Creer une question</div>
      <div class="col-md-12 rounded-bottom form_container">
        <form method="POST" action="" class="myform" id="form_newQst">
			<div class="form-group">
				<label for="question" class="col-2 col-form-label">Question</label>
				<input type="text" name="question" class="form-control" id="question" error="Champ">
				<small  class="form-text text-muted error_form" id="Champ"></small>
			</div>
			<div class="form-group">
				<label for="nbPoint" class="col-2 col-form-label">Points</label>
				<div class="col-10">
					<input class="form-control" type="number" name="nbPoint" error="Nb point" min="1" value="1" id="nbPoint">
					<small  class="form-text text-muted error_form" id="Nb point"></small>
				</div>
			</div>
			<select class="form-control col-8 d-inline" name="select" id="select_type">
				<option selected="" value="">Choisissez le type de reponse</option>
				<option value="checkbox">Choix multiple</option>
				<option value="radio">Choix simple</option>
				<option value="text">Reponse texte</option>
			</select>
			<button type="button" hidden="" id="btn_nvlle_rep"></button>
			<label for="btn_nvlle_rep" id="btn_nvlle_rep"><img src="./public/images/icones/ic-ajout-reponse.png" alt="+"></label>
		    <input type="hidden" name="type" value="creer_question">
			<input type="hidden" name="nb_reponse" id="nb_reponse">
			<div class="form-group" id="reponses"></div>
             <button type="submit" name="nvlleqst" class="btn btn-primary btn_connexion d-block" id="btn_nvelleqst">Enregistrer</button>
        </form>
      </div>
</div>


<?php
	// ajoutQuestion();
?>
<script>
	var reponses = document.getElementById("reponses");
	var nb_reponse = document.getElementById("nb_reponse");
	var select = document.getElementById('select_type');

	 /* Variable Global i */
	 var i = 0;

	/* fonction qui incremente le nombre de champs genere. */
	function increment(){
		i += 1; 
	}

	/* fonction qui reinitialise le nombre de champs genere. */
	function decrement(){
		i = 0; 
	}
	/*
	---------------------------------------------
	Foncion de suppression de reponse
	---------------------------------------------

	*/
	function removeElement(parentDiv, childDiv){
		if (childDiv == parentDiv){
			alert("Le parent ne peut pas etre supprime.");
		}
		else if (document.getElementById(childDiv)){
			var child = document.getElementById(childDiv);
			var parent = document.getElementById(parentDiv);
			parent.removeChild(child);
		}
		else{
			alert("ce div n'existe pas ou a ete supprime.");
			return false;
		}
	}

	/*si on choisi ou on change d'option*/
	select.addEventListener("change",function(){
		reponses.innerHTML="";
		decrement();
		NvelleReponse();
	});
	
	// click sur le bouton +
    $("#btn_nvlle_rep").click(function(){
		NvelleReponse();
	})

	/*
	--------------------------------------------------------------------------
	Fonctions de generation de champs.
	--------------------------------------------------------------------------
	____________Inventaire des variables____________________

	=====   x est le type de question selectionne
	=====   valeur est le type de reponse
	=====   r est l'ensemble des elements d'une reponse
	=====   z est le label ou le nom de la reponse correspondante
	=====   y est le champ de texte de la reponse
	=====   retour permet de retour a la ligne 
	=====   error correspond aux messages d'erreur 
	=====   nb_reponse est le nombre de champ de reponse genere
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	*/
	function NvelleReponse(){
		if (select.value ==""){
			alert("choisissez le type de reponse");
		}
		else{
			increment();
			nb_reponse.setAttribute("value",i);
			var valeur = document.createElement("input");//le type de choix
			valeur.setAttribute("class","mx-2 type_reponse");
			switch(select.value) {
				case "radio":
				    valeur.setAttribute("type","radio");
				    valeur.setAttribute("name","radio");
				    break;
				case "text":
				    valeur.setAttribute("type","radio");
				    valeur.setAttribute("name","radio");
				    valeur.setAttribute("checked","");
				    break;
				default:
				    valeur.setAttribute("type","checkbox");
				    valeur.setAttribute("name","check_list[]");
			}
			valeur.setAttribute("value", "reponse" + i);
			var r = document.createElement('span');//une ligne de reponse
			var z = document.createElement('label');//le titre de la reponse
			var y = document.createElement("INPUT");//le champ de la reponse
			var retour = document.createElement('br');//le retour a la ligne
			var error = document.createElement("small");//gestion de validation
			error.setAttribute("class","error_form");
			error.setAttribute("id","réponse"+i);
			y.setAttribute("type", "text");
			var g = document.createElement("IMG");//le bouton de suppression
			g.setAttribute("src", "./public/images/icones/ic-supprimer.png");
			g.setAttribute("class","mr-2");
			y.setAttribute("name", "reponse" + i);
			y.setAttribute("class", "reponse_gen");
			y.setAttribute("error", "réponse" + i);
			z.setAttribute("for","réponse" + i);
			z.textContent="Reponse  \xa0"+i+" \xa0";
			r.appendChild(z);
			r.appendChild(y);
			r.appendChild(valeur);
			g.setAttribute("onclick", "removeElement('reponses','id_" + i + "')");
			if (select.value!='text') {//pour ne pas pouvoir supprimer une reponse texte
				r.appendChild(g);
			}
			r.setAttribute("id", "id_" + i);
			r.appendChild(error);
			r.appendChild(retour);
			if (select.value=='text' && i>1) {//pour n'avoir qu'une seule reponse texte
				return false;
			}
			reponses.appendChild(r);
		}
	}

	$("#form_newQst").submit(function(){
		event.preventDefault();
		var err = false;
		var check = false;
		$('input[type="text"],input[type="number"]').each(function(){
			let val = $(this).val();
			let attr = $(this).attr('error');
			if (attr && val == "") {
				document.getElementById(attr).innerText = attr+" obligatoire";
				err = true;
			}
		})
		$('input[type="checkbox"],input[type="radio"]').each(function(){
			if ($(this).is(':checked')) {
				check = true;
				return false;
			}
		})
		if (err === false && check === false) {
			alert('au moins une bonne rep')
		}

		if (err === false && check === true) {
			console.log($(this).serializeArray());
			let qst = $(this).serializeArray();
			$.post("./pages/message.php",qst,function(result){
				alert(result);
				$('#form_newQst')[0].reset(); // reinitiqlisqtion des champs
			})
		}
	})
</script>