
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
                        window.location="index.php?user=admin";
                    }
                    else if(result == 'joueur'){
                        window.location="index.php?user=joueur";
                    }
                    else{
                        alert('login ou mot de passe incorrect');
                    }
            });
		}
    });
    
    /*--------------------------------
    Gestion de l'inscrption
    ----------------------------------*/
    $( "#form_inscription" ).on( "submit", function( event ) {
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
				else{
					alert(result)
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
	keyup
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

    /*==================================================
	------------------ PAGE JOUEUR ---------------------
	===================================================*/

$(document).ready(function(){
    meilleursScr();
    /*---------------------------------
    ----Ajouter de nouvelles lignes-----
    -----------------------------------*/ 
    function addLine(values){
        $("#tMeilleursScr").empty();
        let line;
        for(const ligne of values){
            line = `
                <tr class="text-center" id = ligne_${ligne.ID}>
                    <td id = t_prenom_${ligne.ID}>${ligne.PRENOM}</td>
                    <td id = t_nom_${ligne.ID}>${ligne.NOM}</td>
                    <td id = score_${ligne.ID}>${ligne.SCORE}</td>
                </tr>`;
            $("#tMeilleursScr").append(line);
        }
    }
    function meilleursScr(){
        let liste = "joueur";
        let limit = 5;
        let offset = 0;
        $.ajax({
        type: "POST",
        url: "./pages/message.php",
        data: {liste,limit,offset}, //on pouvait faire data: {limit,offset}, si identik
        dataType: "JSON",
        })
        .done(data =>{
            addLine(data);
        })
    }
})