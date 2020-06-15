<div class="col-md-12 loginform mt-5">Liste Questions</div>
<div id="qstcontainer">
    <div class="col-md-12" id="qstListe"></div>
</div>

<script>
    limit = 5;
    offset = 0;
    qstcontainer = $('#qstcontainer')
    qstListe = $('#qstListe')

    loadQuestion()


    function loadQuestion(){
        liste = "question";
		$.ajax({
			type: "POST",
			url: "./pages/message.php",
			data: {liste,limit:limit,offset:offset},
			dataType: "JSON",
		})
		.done(data =>{
            listeQuestion(data);
            console.log(data);
        })
    }

    // liste question
    function listeQuestion(values){
        // qstListe.html('liste des questionnns')
        
		for(let i = 0; i < values.qst.length; i++){
			const qst = `
				<div class="bg-info p-2 mb-2 textLobster" id=${values.qst[i].ID_QST}>${values.qst[i].QUESTION}</div>
				<div class="bg-info p-2 col-3 col-xs-4 text-center float-right  textLobster" id=${values.qst[i].ID_QST}>${values.qst[i].POINT}pts</div>
                <br/><br/>`;
                qstListe.append(qst);
            var j = 0;
            while (values.rep[j].ID_QST <= values.qst[i].ID_QST) {//a optimiser !!!
                if (values.rep[j].ID_QST == values.qst[i].ID_QST) {
                    const rep = values.qst[i].TYPE!='text'?`
				        <div class="textRoboto" id=${values.rep[j].ID_REP}><input type = "${values.qst[i].TYPE}" ${values.rep[j].VALEUR} disabled class="mx-2">${values.rep[j].REPONSE}</div><br/>`:`
				        <div id=${values.rep[j].ID_REP}><input type = "${values.qst[i].TYPE}" value=${values.rep[j].REPONSE} readonly></div><br/>`;
                        qstListe.append(rep);
                }
                j++;
            }
            // for (let j = i; values.rep[j].ID_QST == values.qst[i].ID_QST; j++) {
            //     const rep = `
			// 	<div id=${values.rep[j].ID_REP}>${values.rep[j].REPONSE}</div><br/>`;
            //     qstListe.append(rep);
            // }
        }
    }
    
    
      //  Scroll
      qstcontainer.scroll(function(){
        //console.log(qstcontainer[0].clientHeight)
        const st = qstcontainer[0].scrollTop;
        const sh = qstcontainer[0].scrollHeight;
        const ch = qstcontainer[0].clientHeight;

        // console.log(st,sh, ch);
        
        if(sh-st <= ch){
            // alert('scrolling');
            offset += 5;
            loadQuestion();
        }
           
        })
</script>