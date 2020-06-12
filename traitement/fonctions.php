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
?>
