<div id="creeQuestion">
	<span id="paramVosQuest">PARAMETREZ VOS QUESTIONS</span>
	<div id="question_container">
		<form id="form_creer_question" method="post" action="#">
			<label>Question </label>
			<input type="text" name="question" id="question" error="question_vide">
			<div class="error_form" id="question_vide"></div><br/>
			<label>Nbre de Points </label>
			<input type="number" min="1" name="Nbre_points" id="champ_nb_point" error="point_vide">
			<i class="error_form" id="point_vide"></i><br/>
			<label>Type de reponse</label>
			<select id="select_type" name="select_type_reponse">
				<option selected="" value="">Choisissez le type de reponse</option>
				<option value="choix_multiple">Choix multiple</option>
				<option value="choix_simple">Choix simple</option>
				<option value="reponse_texte">Reponse texte</option>
			</select>
			<button type="button" hidden="" id="btn_nvlle_rep">
			</button>
			<label for="btn_nvlle_rep" id="btn_nvlle_rep"><img src="./public/images/icones/ic-ajout-réponse.png"></label><br/><br/>
			<div id="reponses"></div>
            <input type="submit" name="btn_enregistrer" id="btn_enregistrer" value="Enregistrer" class="btn" onclick="function(e){
                e.preventDefault()}">
		</form>
	</div>
	<div id="msg_error"></div>
</div>


<?php
	// ajoutQuestion();
?>

<script type="text/javascript">

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


	/*definition du conteneur des reponses*/
	var reponses = document.getElementById("reponses"),
	msg_error = document.getElementById('msg_error');

	/*si on choisi ou on change d'option*/
	var a = document.getElementById('select_type');
	a.addEventListener("change",function(){
		reponses.innerHTML="";
		decrement();
		if (a.value!="") {
			NvelleReponse();
		}
	});
	/*si on clique sur le bouton + */
	var b = document.getElementById('btn_nvlle_rep');
	b.addEventListener("click",function(){
			NvelleReponse();
	});

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
		var x = document.getElementById('select_type').value;//l'option selectionne
		if (x==""){
			alert("choisissez le type de reponse") ;
		}
		else{
			increment();
			var valeur = document.createElement("input");//le type de choix
			valeur.setAttribute("class","type_reponse");
			switch(x) {
				case "choix_simple":
				    valeur.setAttribute("type","radio");
				    valeur.setAttribute("name","radio");
				    break;
				case "reponse_texte":
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
			var error = document.createElement("i");//gestion de validation
			var nb_reponse = document.createElement("input");//le nbre total de reponse
			nb_reponse.setAttribute("type","hidden");
			nb_reponse.setAttribute("name","nb_reponse");
			nb_reponse.setAttribute("value",i);
			error.setAttribute("class","error_form");
			error.setAttribute("id","error"+i);
			y.setAttribute("type", "text");
			var g = document.createElement("IMG");//le bouton de suppression
			g.setAttribute("src", "./public/images/icones/ic-supprimer.png");
			g.setAttribute("class","btn_suppr_rep");
			y.setAttribute("name", "reponse" + i);
			y.setAttribute("error", "error" + i);
			z.setAttribute("for","reponse" + i);
			z.textContent="Reponse "+i+" ";
			r.appendChild(z);
			r.appendChild(y);
			r.appendChild(valeur);
			g.setAttribute("onclick", "removeElement('reponses','id_" + i + "')");
			if (x!='reponse_texte') {//pour ne pas pouvoir supprimer une reponse texte
				r.appendChild(g);
			}
			r.setAttribute("id", "id_" + i);
			r.appendChild(error);
			r.appendChild(nb_reponse);
			r.appendChild(retour);
			if (x=='reponse_texte' && i>1) {//pour n'avoir qu'une seule reponse texte
				return false;
			}
			reponses.appendChild(r);
			if (i>5) {
				document.getElementById('question_container').style.borderStyle="none";
			}
		}
	}


	/*-----------------------------------------
				validation formulaire
	-------------------------------------------
	*/
	const inputs = document.getElementsByTagName("input");
	for(input of inputs){
		input.addEventListener("keyup",function(e){
			if (e.target.hasAttribute("error")) {
				var idDivError = e.target.getAttribute("error");
				document.getElementById(idDivError).innerText = ""
			}
		})
	}
	document.getElementById('form_creer_question').addEventListener('submit',function(e){
		const inputs = document.getElementsByTagName('input');
		var error  = false,
			count = false;
		for(input of inputs){
			if (input.hasAttribute('error')) {
				var idDivError = input.getAttribute('error');
				if (!input.value) {
					document.getElementById(idDivError).innerText = "Obligatoire.";
					error = true;
				}
			}
			if (input.type === "checkbox" && input.checked === true) {
	          count = true;
	        }
	        if (input.type === "radio" && input.checked === true) {
	          count = true;
	        }
		}
		if (!error && !count) {
			alert('Cochez au moins une bonne reponse') ;
			error = true;
		}

		if (error) {
			e.preventDefault();
			return false;
		}
	})
</script>
