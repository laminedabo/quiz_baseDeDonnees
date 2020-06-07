<div class="mt-5">
    <div class="container col-md-8 float-left">
        <div class="col shadow">
            <table class="table table-striped">
                <thead>
                    <tr class="text-center">
                        <th>Prenoms</th>
                        <th>Noms</th>
                        <th>Scores</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    
                </tbody>
            </table>
        </div>
        <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
            <a class="page-link btn btn-primary" href="">Precedent</a>
            </li>
            <li class="page-item">
            <a class="page-link btn btn-primary active" href="">Suivant</a>
            </li>
        </ul>
        </nav>
    </div>
    <div class="container infos col-md-4 float-left shadow-sm border d-flex justify-content-center"><img src="./photos/user.png" alt="user img" id="gamer_img"></div>
</div>


    <!-- recuperer le nombre total de joueurs -->
    <?php
        include_once('../data/requetes.php');
        try{
            $db = connect_db();
            $query = $db -> prepare("SELECT * FROM `utilisateur` WHERE `PROFIL` = 'joueur'");
            $query -> execute();
            $total_gamers = $query -> rowCount();
        }
        catch(PDOException $e){
            die("erreur: ".$e -> getMessage());
        }
    ?>
    <input type = "hidden" id = "total_gamers" value = "<?php echo $total_gamers; ?>">
<script>
    /*================================================================
	------------------PARTIE LISTE DES JOUEURS------------------------
	=================================================================*/
    var i = 1;//numero page
    var l = 1;//numero ligne
    var limit = 5;
    var offset = 0;
    var total_gamers = $("#total_gamers").val();
    var nb_page = Math.ceil(total_gamers/limit);

    /*-----------------------------------------------------
	pagination
	-------------------------------------------------------*/
	
    $(".pagination .page-item a").click(function(e){
		e.preventDefault()
        // alert($(this).text())
        if($(this).text() === 'Suivant'){
            i++;
            offset += 5;
        }
        else{
            i--;
            offset -= 5;
        }
        listeJoueurs();
        
        if(i > 1){
            $(".pagination").find(".disabled").removeClass("disabled").addClass("active")
        }
        else{
            $(this).addClass("disabled")
        }
        if(i === nb_page){
            $(this).addClass("disabled")
        }
    })

    /*-----------------------------------------------------
	fonction liste
	-------------------------------------------------------*/
	function listeJoueurs(){
        let liste = "joueur";
		$.ajax({
			type: "POST",
			url: "./pages/message.php",
			data: {liste,limit:limit,offset:offset}, //on pouvait faire data: {limit,offset}, si identik
			dataType: "JSON",
		})
		.done(data =>{
            // const value = JSON.parse(data);
            addLine(data);
        })
	}
	/*---------------------------------
	----Ajouter de nouvelles lignes-----
	-----------------------------------*/ 
	function addLine(values){
        $("#tbody").empty();
		let line;
		for(const ligne of values){
			line = `
				<tr class="text-center" id = ligne_${l}>
					<td id = prenom_${l}>${ligne.PRENOM}</td>
					<td id = nom_${l}>${ligne.NOM}</td>
					<td id = score_${l}>${ligne.ID}</td>
				</tr>`;
			l++;
			$("#tbody").append(line);
		}
    }
    listeJoueurs();
</script>