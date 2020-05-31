<?php 
	if (!isset($_SESSION)) {
		session_start();
	}
	

	/*verfier si l'utilisateur est connecte*/
	function is_connected(){
		if (!isset($_SESSION['statut'])) {
			?>
          <script>
          window.location="index.php";
          </script>
          <?php
		}
		else{
			return true;
		}
	}

	function deconnexion(){
		if (isset($_SESSION['user'])) {
			unset($_SESSION['user']);
			unset($_SESSION['statut']);
			session_destroy();
		}
	}

	/*fonction d'affichage de la liste des joueurs*/
	function listeJoueurs(){
		$joueur = getData();
    	$tab = array();
    	foreach ($joueur as $key => $value) {
    		if ($value['profil']=='joueur') {
    			$tab[] = $value;
    		}
    	}
		if (!empty($tab)) {
			return triScore($tab);
		}
	}

	/*trier les scores par ordre decroissant*/
	function triScore($tab=[]){
		$tmp = array();
		$i = 0;
		for ($i = 0; $i < count($tab) -1; $i++) { 
			for ($j=$i; $j < count($tab) -1 ; $j++) { 
				if($tab[$i]['score'] < $tab[$j+1]['score']) {
					$tmp = $tab[$i];
					$tab[$i] = $tab[$j+1];
					$tab[$j+1] = $tmp;
				}
			}
		}
		return $tab;
	}

	/*paginer la liste des joueurs*/
	function pagination($tab=[],$nbrParpage)
    {
        $nbPage = ceil(count($tab)/$nbrParpage);
        if (isset($_GET['val'])){
            $page = (int)$_GET['val'];
        }
        else{
            $page = 1;
        }
        $pre = (int)($page-1);
        $suiv = (int)($page+1);
        $min = (int)($page-1)*$nbrParpage;
        $max = (int)($page)*$nbrParpage;
        for ($i=$min;$i<$max;$i++) {
            if (isset($tab[$i])) {
                echo "<td>".strtoupper($tab[$i]['nom'])."</td>
                <td>".$tab[$i]['prenom']."</td>
                <td>".$tab[$i]['score']."</td></tr>";
            }
        }
        if ($pre>=1) {
            echo('<a id="precedent" class="btn"  href="index.php?user=admin&val='.$pre.'">Precedent</a>');
        }
        if ($suiv<=$nbPage) {
            echo('<a id="suivant" class="btn" href="index.php?user=admin&val='.$suiv.'">  Suivant</a>');
        }
    }
    /*inscription*/
    function inscription(){
    	$tab = array();
    	$msg = "";
    	if (isset($_POST['btn_creer_compte'])) {
    		if (!empty($_POST['prenomInsc']) and !empty($_POST['nomInsc']) and !empty($_POST['loginInsc']) and !empty($_POST['passInsc']) and !empty($_POST['confirmPW'])){
    			if ($_POST['passInsc']==$_POST['confirmPW']) {
	    			$tab['prenom'] = $_POST['prenomInsc'];
	    			$tab['nom'] = $_POST['nomInsc'];
	    			$tab['login'] = $_POST['loginInsc'];
	    			$tab['pass'] = $_POST['passInsc'];
    			}
    		}
    		else{
    			$msg = "<div id='msg_inscr'>remplissez tous les champs.</div>";
    		}
    		if (!empty($tab)) {
	    		if (uploadImage()) {
	    			$tab['image'] = uploadImage();
	    		}
	    		if (isset($_SESSION['user'])  && $_SESSION['user']['profil']=='admin') {
	    			$tab['profil'] = 'admin';
	    		}
	    		else{
	    			$tab['profil'] = 'joueur';
	    			$tab['score'] = 0;
	    		}
	    		if (addData($tab) != false) {
	    			if (isset($_SESSION['user']) && $_SESSION['user']['profil']=='admin') {
	    				$msg = "<div id='msg_inscr'>Un admin a ete ajoute avec succes.</div>";
	    			}
	    			else{
	    				$msg = "<div id='msg_inscr'>inscription reussie. vous pouvez vous <a href='index.php'> &nbsp connecter ici</a></div>";
	    			}
	    		}
	    		else{
	    			$msg =  "<div id='msg_inscr'>login deja existant</div>";
	    		}
	    	}
    		else{
    			$msg ="<div id='msg_inscr'>les mots de pass doivent etre identiques.</div>";
    		}
	    	echo($msg);
    	}
    }
	/*chargement de l'image*/
	function uploadImage(){
		$msg = "";
		if (!empty($_FILES["img"]) and $_FILES['img']['error'] == 0) {
			$dossier_photos = "photos/";
			$chemin_photos = $dossier_photos . basename($_FILES["img"]["name"]);
			$uploadOk = true;
			$imageFileType = strtolower(pathinfo($chemin_photos,PATHINFO_EXTENSION));
			// Verifier si c'est vraiment une image
    		$check = getimagesize($_FILES["img"]["tmp_name"]);
    		if($check == false) {
	        	$msg =  "<div id='msg_inscr'>Selectionnez un fichier de type image svp.</div>";
	        	$uploadOk = false;
	    	} 
			// limiter la taille de l'image a 1Mo
			elseif ($_FILES["img"]["size"] > 1048576) {
	    		$msg =  "<div id='msg_inscr'>La taille de l'image ne doit pas depasser 1Mo.</div>";
	    		$uploadOk = false;
			}
			// Autoriser certains formats de fichier
			elseif($imageFileType != "png" && $imageFileType != "jpeg") {
	    		$msg =  "<div id='msg_inscr'>Seuls les formats png et jpeg sont autorises.<div>";
	    		$uploadOk = false;
			}
			// Si une image de meme nom existe dans le dossier
			elseif (file_exists($chemin_photos)) {
			    $msg =  "<div id='msg_inscr'>Une image de meme nom existe dans le dossier.</div>";
			    $uploadOk = false;
			}
			// si tout va bien. on va charger l'image 
			if ($uploadOk != false) {
				/*le mettre ici*/
				move_uploaded_file($_FILES["img"]["tmp_name"], $chemin_photos);
			}
			echo $msg;
			return $chemin_photos;
		}
	}

/* a ne pas oublier de 
	if (move_uploaded_file($_FILES["img"]["tmp_name"], $chemin_photos)) {
	        		echo "Le fichier ". basename( $_FILES["img"]["name"]). " a ete chargee.";
	        		return $chemin_photos;
	    		} 
	    		else {
	        		return null;
	    		}
			}*/


	/*Affichage des scores des 5 meilleurs joueurs*/
	function topScores(){
		$tab  = listeJoueurs();
		echo('<div id="topScor">');
		for ($i=0; $i < 5; $i++) { 
			echo'<div><div style="float:left;">'. $tab[$i]['prenom'].' '.$tab[$i]['nom'].'</div><div style="float:right;"> '.$tab[$i]['score'].'pts</div><br><br>';
		}
		echo('</div>');
	}

	/*----------------------------------------------------
	fonction permettant d'ajouter une question
	------------------------------------------------------*/
	function ajoutQuestion(){
		if (isset($_POST['btn_enregistrer'])) {
			$tab=[];
			$s = 0;
			$msg = "";
			if(!empty($_POST['question']) and !empty($_POST['Nbre_points']) and !empty($_POST['select_type_reponse'])){
				if (!is_numeric($_POST['Nbre_points']) or $_POST['Nbre_points']<1) {
					$msg = "nbre de points invalide";
				}
				elseif (empty($_POST['check_list']) and empty($_POST['radio'])){
					$msg = "Il faut au moins une reponse exacte";
				}
				else{
					$nb_reponse = isset($_POST['nb_reponse'])?$_POST['nb_reponse']:"";
					$tab['question'] = $_POST['question'];
					switch ($_POST['select_type_reponse']) {
						case 'choix_multiple':
							$bonne_rep = $_POST['check_list'];
							$tab['type'] = 'choix_multiple';
							for ($i=1; $i <=$nb_reponse ; $i++) {
								if (!empty($_POST['reponse'.$i])) {
								    $s++;
								 	$tab['reponse'.$s]['val']=$_POST['reponse'.$i];
								 	if (in_array('reponse'.$i, $bonne_rep)) {
								 		$tab['reponse'.$s]['correcte']="oui";
								 	}
								 	else{
								 		$tab['reponse'.$s]['correcte']="non";
								 	}
								}
							}
							break;
						case 'choix_simple':
							$tab['type'] = 'choix_simple';
							$radio = $_POST['radio'];
							for ($i=1; $i <=$nb_reponse ; $i++) {
								if (!empty($_POST['reponse'.$i])) {
								    $s++;
								 	$tab['reponse'.$s]['val']=$_POST['reponse'.$i];
								 	if ($radio == 'reponse'.$i) {
								 		$tab['reponse'.$s]['correcte']="oui";
								 	}
								 	else{
								 		$tab['reponse'.$s]['correcte']="non";
								 	}
								}
							}
							break;
						default:
							$tab['type'] = 'reponse_texte';
							$tab['reponse1']['val']=$_POST['reponse1'];
							$tab['reponse1']['correcte']="oui";
							break;
					}
					$tab['point'] = $_POST['Nbre_points'];
				}
			}
			if (!empty($tab)) {
				if (addQuestion($tab)) {
					$msg = "La question a ete ajoutee avec succes.";
				}
			}
			if (!empty($msg)) {
				?>
					<script type="text/javascript">
						alert('<?= $msg;?>');
					</script>
				<?php
			}
		}
	}


	/*variable globale du fichier json des questions*/
	define('fileName', './json/questions.json'); 
/*	________________________________________________*/

	/*----------------------------------------------
	insertion d'une question dans le fichier json
	------------------------------------------------*/
	function addQuestion($value=[])
	{
		if (file_exists(fileName)) {
			$content = file_get_contents(fileName);
			$decode = json_decode($content,true);
			$value['id_question'] = count($decode)+1;
			$decode[] = $value;
			$encode = json_encode($decode,JSON_PRETTY_PRINT);
			if (file_put_contents(fileName, $encode)) {
				return true;
			}
		}
		return false;
	}
	/*----------------------------------------------
	recuperation des questions dans le fichier json
	------------------------------------------------*/
	function getQuestion()
	{
		if (file_exists(fileName)) {
			$content = file_get_contents(fileName);
			$decode = json_decode($content,true);
		}
		return $decode;
	}

	/*----------------------------------------------
			pagination des questions pour l'admin
	------------------------------------------------*/
	function paginer_liste_question($tab=[],$nbrParpage=5)
	{
		$nbPage = ceil(count($tab)/$nbrParpage);
        if (isset($_GET['pg'])){
            $page = (int)$_GET['pg'];
        }
        else{
            $page = 1;
        }
        $pre = (int)($page-1);
        $suiv = (int)($page+1);
        $min = (int)($page-1)*$nbrParpage;
        $max = (int)($page)*$nbrParpage;
        for ($i=$min;$i<$max;$i++) {
            if (isset($tab[$i])) {
            	echo $tab[$i]['id_question'].'. '.$tab[$i]['question'].'<br/>';
                if ($tab[$i]['type'] == 'choix_multiple') {
                	$j=1;
                	while (isset($tab[$i]['reponse'.$j])) {
	                	    if ($tab[$i]['reponse'.$j]['correcte']==='oui') {
    	                		$reponse = '<input type="checkbox" checked="">'.$tab[$i]['reponse'.$j]['val'].'<br/>';
    	                	}
    	                	else{
    	                		$reponse = '<input type="checkbox">'.$tab[$i]['reponse'.$j]['val'].'<br/>';
    	                	}
    	                	echo '<div id="reponse">'.$reponse.'</div>';
    	                	$j++;
                	}
                }
                elseif ($tab[$i]['type'] == 'choix_simple') {
                	$j=1;
                	while (isset($tab[$i]['reponse'.$j])) {
    	                if ($tab[$i]['reponse'.$j]['correcte']==='oui') {
    	                	$reponse = '<input type="radio" checked="">'.$tab[$i]['reponse'.$j]['val'].'<br/>';
    	                }
    	                else{
    	                	$reponse = '<input type="radio">'.$tab[$i]['reponse'.$j]['val'].'<br/>';
    	                }
    	                echo '<div id="reponse">'.$reponse.'</div>';
    	                $j++;
                	}
                }
                else{
                	echo '<input type="text" readonly value="'.$tab[$i]['reponse1']['val'].'"><br/>';
                }
            }
        }
        if ($pre>=1) {
            echo('<a id="list_precedent" class="btn"  href="index.php?user=admin&menu=listeQuestions&pg='.$pre.'">Precedent</a>');
        }
        if ($suiv<=$nbPage) {
            echo('<a id="list_suivant" class="btn" href="index.php?user=admin&menu=listeQuestions&pg='.$suiv.'">  Suivant</a>');
        }
	}


	/*----------------------------------------------
			definition du nombre de question/jeu
	------------------------------------------------*/
	function nbQuestionParJeu()
	{
		if (file_exists('./json/nbQst.json')) {
			$content = file_get_contents('./json/nbQst.json');
			$decode = json_decode($content,true);
		}
		if (isset($_POST['btn_nbQuestParJeu'])) {
			if (!empty($_POST['champNbQuest']) and is_numeric($_POST['champNbQuest']) and $_POST['champNbQuest']>=5) {
				$decode['nbQstParJeu'] = $_POST['champNbQuest'];
				$encode = json_encode($decode);
				file_put_contents('./json/nbQst.json', $encode);
			}
			else{
				echo "erreur";
			}
		}
		if (isset($decode)) {
			return $decode['nbQstParJeu'];
		}
		return 5;
	}

	/*----------------------------------------------
			pagination des questions pour le joeur
	------------------------------------------------*/
	function jouer($questions=[],$nbrParpage=1)
	{
		$tab = [];
		$nb_qst_max = nbQuestionParJeu();
		for ($i=0; $i < $nb_qst_max; $i++) { 
			if (isset($questions[$i])) {
				$tab[] = $questions[$i];
			}
		}
		$nbPage = ceil(count($tab)/$nbrParpage);
        if (isset($_POST['qst_suivante']) || isset($_POST['Terminer'])){
        	traiterQuestion($_POST);
        	$qst = $_POST['qst'];
        }elseif (isset($_POST['qst_precedente'])){
        	$qst = $_POST['qst'] -2;
        }
        else{
            $qst = 0;
        }
        if (isset($_POST['Terminer'])) {
        	miseAjourScores($_SESSION['user']['login']);
        	recap();
        }
        
        
        $pre = (int)($qst-1);
        $suiv = (int)($qst+1);
        $nb_qst = count($tab);
        $i = $qst;
        ?>

        <form method="post" action="#" id="form_reponse">

        <?php
            if (isset($tab[$i])) {
            	echo '<div id="current_qstn"><u><b>Question '.($i+1).'/'.$nb_qst.':</b></u><br/>'.$tab[$i]['question'].'</div>';
            	echo '<div id="pt_current_qstn">'.$tab[$i]['point'].'pts</div>';
            	echo '<div id="reponse_container">';
                if ($tab[$i]['type'] == 'choix_multiple') {
                	$j=1;
                	while (isset($tab[$i]['reponse'.$j])) {
	                	$reponse = '<input type="checkbox" name="chek_reponse_multi[]" value="reponse'.$j.'">'.$tab[$i]['reponse'.$j]['val'].'<br/>';
	                	echo '<div id="current_reponse">'.$reponse.'</div>';
	                	$j++;
                	}
                }
                elseif ($tab[$i]['type'] == 'choix_simple') {
                	$j=1;
                	while (isset($tab[$i]['reponse'.$j])) {
	                	$reponse = '<input type="radio" name="chek_reponse_radio" value="reponse'.$j.'">'.$tab[$i]['reponse'.$j]['val'].'<br/>';
	                	echo '<div id="current_reponse">'.$reponse.'</div>';
	                	$j++;
                	}
                }
                else{
                	echo '<input type="text" name="chek_reponse_texte" placeholder="tapez la reponse"><br/>';
                }
                echo '</div>';
            }
            
        if ($i>=1) {
            echo('<input type="submit" name="qst_precedente" id="qst_precedente" class="btn" value="Precedent">');
        }
        if ($i<$nbPage-1) {
            echo('<input type="submit" id="qst_suivante" name="qst_suivante" class="btn" value="Suivant">');
        }
        if ($i==$nbPage-1) {
            echo('<input type="submit" id="qst_suivante" name="Terminer" class="btn" value="Terminer">');
        }
        echo('<input type="submit" id="quitter" name="quitter" class="btn" value="Quitter le quiz">');

        ?>
        <input type="hidden" name="qst" value="<?= ++$qst?>">
        <input type="hidden" name="id" value="<?=$tab[$i]['id_question']?>">
		</form>
		<?php
	}

	/*----------------------------------------------
			traitement des questions
	------------------------------------------------*/
	function traiterQuestion($qstn=[]){
		$questions = getQuestion();
		//on recupere l'id de la question
		$i = $qstn['id'];
		$j = 1;
		$scr = 0;
		$current = end($_SESSION['questionsRepondues']);
		if (isset($current['id_question'])) {
			if ($current['id_question'] < $questions[$i-1]['id_question']) {
				$_SESSION['questionsRepondues'][] = $questions[$i-1];
			}
		}
		else{
			$_SESSION['questionsRepondues'][] = $questions[$i-1];
		}
		
		if (isset($qstn['chek_reponse_multi'])) {
			$s = $qstn['chek_reponse_multi'];
			//$i-1 c'est la position de la question... 
			while (isset($questions[$i-1]['reponse'.$j])) {
				if (in_array('reponse'.$j, $s)) {
					if ($questions[$i-1]['reponse'.$j]['correcte']==='non'){
						$scr = 0;
						break;
					}
					elseif ($questions[$i-1]['reponse'.$j]['correcte']==='oui'){
						$scr = $questions[$i-1]['point'];
					}
				}
				elseif(!in_array('reponse'.$j, $s) and $questions[$i-1]['reponse'.$j]['correcte']==='oui'){
					$scr = 0;
					break;
				}
				$j++; 
			}
		}
		elseif (isset($qstn['chek_reponse_radio'])) {
			$s = $qstn['chek_reponse_radio'];
			$rep = false;
			while (isset($questions[$i-1]['reponse'.$j])) {
				if ($questions[$i-1][$s]['correcte']==='oui'){
					$rep = true;
					break;
				}
				$j++; 
			}
			if ($rep == true) {
			$scr = $questions[$i-1]['point'];
			}
		}
		elseif (isset($qstn['chek_reponse_texte'])) {
			$s = $qstn['chek_reponse_texte'];
			if ($s == $questions[$i-1]['reponse1']['val']) {
				$scr = $questions[$i-1]['point'];
			}
		}
		if ($scr != 0) {
			if (!in_array($questions[$i-1]['id_question'], $_SESSION['questionsTrouvees'])) {
				$_SESSION['questionsTrouvees'][]= $questions[$i-1]['id_question'];
				$_SESSION['pointsAccumules'] += $scr;
			}
		}
	}

	function recap()
	{
		?>
	<div id="recap">
		<?php
		echo('<h3>RECAPITULATIF DE VOS REPONSES</h3>');
		foreach ($_SESSION['questionsRepondues'] as $value) {
			if (in_array($value['id_question'], $_SESSION['qstTotalTrouvees'])) {
				echo '<img src="./photos/valid.png">'. $value['id_question'].'. '.$value['question'].'<br/>';

				if ($value['type'] == 'choix_multiple') {
                	$j=1;
                	while (isset($value['reponse'.$j])) {
	                	if ($value['reponse'.$j]['correcte']==='oui') {
	                		$reponse = '<input type="checkbox" checked="">'.$value['reponse'.$j]['val'].'<br/>';
	                	}
	                	else{
	                		$reponse = '<input type="checkbox">'.$value['reponse'.$j]['val'].'<br/>';
	                	}
	                	echo '<div id="reponse">'.$reponse.'</div>';
	                	$j++;
                	}
                	echo('<br/>');
                }
                elseif ($value['type'] == 'choix_simple') {
                	$j=1;
                	while (isset($value['reponse'.$j])) {
	                	if ($value['reponse'.$j]['correcte']==='oui') {
	                		$reponse = '<input type="radio" checked="">'.$value['reponse'.$j]['val'].'<br/>';
	                	}
	                	else{
	                		$reponse = '<input type="radio">'.$value['reponse'.$j]['val'].'<br/>';
	                	}
	                	echo '<div id="reponse">'.$reponse.'</div>';
	                	$j++;
                	}
                }
                else{
                	echo '<input type="text" readonly value="'.$value['reponse1']['val'].'"><br/>';
                }
                echo('<br/>');
			}
			else{
				echo '<img src="./photos/false.jpg">'. $value['id_question'].'. '.$value['question'].'<br/>';

				if ($value['type'] == 'choix_multiple') {
                	$j=1;
                	while (isset($value['reponse'.$j])) {
	                	$reponse = '<input type="checkbox">'.$value['reponse'.$j]['val'].'<br/>';
	                	echo '<div id="reponse">'.$reponse.'</div>';
	                	$j++;
                	}
                	echo('<br/>');
                }
                elseif ($value['type'] == 'choix_simple') {
                	$j=1;
                	while (isset($value['reponse'.$j])) {
	                	$reponse = '<input type="radio">'.$value['reponse'.$j]['val'].'<br/>';
	                	echo '<div id="reponse">'.$reponse.'</div>';
	                	$j++;
                	}
                	echo('<br/>');
                }
                else{
                	echo '<input type="text" readonly><br/>';
                }
                echo('<br/>');
			}
		}
		echo('<center>Score obtenu: '.$_SESSION['pointsAccumules'].'</center>');
		?>
	<a href="index.php?user=joueur"  class="btn_recap rejouer">Rejouer</a>
	<a href="https://twitter.com/ldab_developer" class="btn_recap author" >L'auteur</a>
	</div>
		<?php
	}

	function miseAjourScores($login='')
	{
		$total_point = $_SESSION['pointsAccumules'];
		$questionsTrouvees = $_SESSION['questionsTrouvees'];
		$fileName = './json/infos.json';
		$contenu = file_get_contents($fileName);
		$user = json_decode($contenu,true);
		foreach ($user as $key => $value) {
			if ($value['profil'] == 'joueur' && $value['login'] == $login) {
			break;	
			}
		}
		if (!isset($user[$key]['questionsTrouvees'])) {
			$user[$key]['questionsTrouvees'] = $questionsTrouvees;
		}
		else{
			for ($i=0; $i < count($questionsTrouvees); $i++) { 
				if (!in_array($questionsTrouvees[$i], $user[$key]['questionsTrouvees'])) {
					$user[$key]['questionsTrouvees'][] = $questionsTrouvees[$i];
				};
			}
		}
		$_SESSION['qstTotalTrouvees'] = $user[$key]['questionsTrouvees'];
		if ($value['score'] < $total_point) {
			$user[$key]['score'] = $total_point;
			$_SESSION['user']['score'] = $total_point;
		}
		$user = json_encode($user, JSON_PRETTY_PRINT);
		file_put_contents($fileName, $user);
	}
?>
