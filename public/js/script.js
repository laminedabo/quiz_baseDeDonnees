
/*-----------------------------------------------------
recuperation DOM
-------------------------------------------------------*/
const inputs = document.getElementsByTagName("input");
const pageActuAdm = document.getElementById("pageActuAdmin");


/*-----------------------------------------------------
document.ready
-------------------------------------------------------*/ 
$(document).ready(function(){


	/*--------------------------------
    Gestion de l'authentification
    ----------------------------------*/ 
    $( "#form_connexion" ).on( "submit", function( event ) {
        event.preventDefault()
        var error  = false;
        for(input of inputs){
            if (input.hasAttribute('error')) {
                var idDivError = input.getAttribute('error');
                if (!input.value) {
                    document.getElementById(idDivError).innerText = idDivError+" requis.";
                    error = true;
                }
            }
        }
        if (error != true){
            let fields = $( this ).serializeArray();
            $.post("./pages/message.php", fields,
                function(result) {
                    if(result == 0){
                        alert('Erreur');
                    }
                    else if(result == 'admin'){
                        window.location.replace("./pages/accueil.php");
                    }
                    else if(result == 'joueur'){
                        window.location.replace("./pages/joueur.php");
                    }
                    else{
                        alert('login ou mot de pass incorect');
                    }
            });
        }        
    });
    
    /*--------------------------------
    Gestion de l'inscrption
    ----------------------------------*/
    $( "#form" ).on( "submit", function( event ) {
        event.preventDefault();
        var error  = false;
        for(input of inputs){
            if (input.hasAttribute('error')) {
                var idDivError = input.getAttribute('error');
                if (!input.value) {
                    document.getElementById(idDivError).innerText = idDivError+" requis.";
                    error = true;
                }
            }
        } 
        if (error != true){
            let fields = $( this ).serializeArray();
            $.post("./pages/message.php", fields, function(result) {
                if(result == 1){
                    alert('un admin a été ajouté');
                    $('#form_inscription')[0].reset(); // reinitiqlisqtion des champs
                }
                else if(result == 2){
                    alert('inscription reussie. Vous allez etre redirigé sur la page de connexion.');
                    window.location.replace("index.php");
                }
            });
        }
	});
	
	/*-----------------------------------------------------
	controle le lien activé
	-------------------------------------------------------*/
	$(".nav .nav-item a").click(function(){
		event.preventDefault();
		let lien = $(this).attr('href')
		if(lien != '#'){
			$("#pageActuAdmin").load(lien)
		}
		$(".nav .nav-item").find(".active").removeClass("active");
		$(this).addClass("active");
	});
	
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
})