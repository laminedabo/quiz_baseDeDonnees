
/*-----------------------------------------------------
recuperation DOM
-------------------------------------------------------*/
const inputs = document.getElementsByTagName("input");


/*-----------------------------------------------------
fonctions
-------------------------------------------------------*/
	for(input of inputs){
		input.addEventListener("keyup",function(e){
			if (e.target.hasAttribute("error")) {
				var idDivError = e.target.getAttribute("error");
				document.getElementById(idDivError).innerText = ""
			}
		})
	}

	document.getElementById('form_connexion').addEventListener('submit',function(e){
		var error  = false;
		for(input of inputs){
			if (input.hasAttribute('error')) {
				var idDivError = input.getAttribute('error');
				if (!input.value) {
					document.getElementById(idDivError).innerText = "Ce champ est obligatoire.";
					error = true;
				}
			}
		}
		if (error) {
			e.preventDefault();
			return false;
		}
	})