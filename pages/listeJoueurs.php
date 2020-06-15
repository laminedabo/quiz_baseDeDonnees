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
    <div class="p-2 infos col-md-4 float-left shadow-sm border  justify-content-center"><img src="./photos/user.png" alt="user img" id="gamer_img">
    <div class="action">
    <button class="btn btn-danger col-6 p-0 suppr">Supprimer</button>
    <button class="btn btn-danger col-5 p-0 bloq">Bloquer</button>
    </div>
    </div>
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
				<tr class="text-center" id = ligne_${ligne.ID}>
					<td class="prn" id = t_prenom_${ligne.ID}>${ligne.PRENOM}</td>
					<td class="nm" id = t_nom_${ligne.ID}>${ligne.NOM}</td>
					<td id = score_${ligne.ID}>${ligne.SCORE}</td>
				</tr>`;
			$("#tbody").append(line);
		}
    }
    listeJoueurs();


$(document).ready(function(){
        // 
    let coul;
    let clone;
    let type;
    let objEnCours=null;
    // 
	$("#tbody")
    .on("click","tr",function(){
    //  alert($(this).html())
        let identif = $(this).attr("id");
        const tab = identif.split("_");
        identif = tab[1];
        // alert(identif);
        $(".suppr, .bloq").attr("id",identif);
       coul=$("#tbody").css("background-color");
       $(this).css("background-color","orange");
       $("#tbody tr").not(this).css("background-color",coul);
    })

    .on('dblclick',"td",function(){
        // $(this).parents().css("background-color",coul);
        const id =$(this).attr("id");
        const tab = id.split("_");
        objEnCours=$(this);
        //console.log($(this).children().clone());
        type=tab[0];
        clone=type==="i"?$(this).children().clone():$(this).text();
    //    alert(clone)
        if((type==='t') || (type ==='i')){
            const input=getInput(tab,clone);
            $(this).html(input);
            $(this).children().focus();
        }
    })

    .on("focusout","td",function(e){
        
        const {id,value} = e.target;
        const tab=id.split("_");
        if(type==='t') {
            if(value.trim() != ""){
                $(this).html(value); 
                const data={
                    "update":"joueur",
                    "table":"utilisateur",
                    "champ":tab[0],
                    "id":tab[1],
                    "val":value
                }
                $.ajax({
                method:"POST",
                url: "./pages/message.php",
                data:data
                })
                .done(data =>{
                    alert(data);
                })
                // upDonneesBd(data);
            }
            else{
                $(this).html(clone);
            } 
        }
        else if(type==='i'){
            if(value.trim() != ""){
               const file_data =e.target.files[0];
               //console.log(file_data);
               let data = new FormData();
               data.append('file',file_data);
               data.append('table',"images");
               data.append('id',tab[1]);
               upDonneesImg(data);
            }            
        }
        //console.log(e);
    })

    $(".suppr, .bloq").click(function(){
        // alert($(this).attr('id'))
        // alert($(this).html())
        let id = $(this).attr('id');
        let action = $(this).html();
        if (id) {
            let ln = 'ligne_'+id;//la ligne c a d le joueur
            let prn = $('#'+ln).find('.prn').html();//son prenom
            if (confirm('Vous aller '+action+' '+prn+' ?')) {
                const data={
                    "action":action,
                    "table":"joueur",
                    "id":id
                }
                $.ajax({
                method:"POST",
                url: "./pages/message.php",
                data:data
                })
                .done(data =>{
                    console.log(data);
                })
                if (action === 'Supprimer') {
                    $('#'+ln).hide();
                }
            }
        }
        else{
            alert('Selectionnez un Joueur')
        }
    })
})









    // 
    function getInput(tab,txt){
        const tp={
            "t":"text",
            "i":"file"
        };
        type=tab[0];
        const v= type=="i"?' accept="image/png, image/jpeg"':` value="${txt}"`;
        const input = `<input type ="${tp[type]}" id="${tab[1]}_${tab[2]}" ${v} />`;
        return input;
    }
</script>