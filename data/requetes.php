<?php
	if(!isset($_SESSION)){
		session_start();
	}
	/*--------------------------------------------------------
	connexion a la BDD
	----------------------------------------------------------*/
    function connect_db(){
		$host = "localhost";
		$db = "quiz";
		$user = "ldab";
		$psswd = "mypassword";
        try{
            $conn = new PDO("mysql:host=$host;dbname=$db",
            $user,$psswd);
            return $conn;
        }catch(PDOException $pe){
            return 'connection error '.$pe->getMessage();
            die();
        }
    }

	/*---------------------------------------------------------
	inserer les infos utilisateur dans la BDD
	----------------------------------------------------------*/
	function addUser($prenom,$nom,$login,$password)
    {
		if(isset($_SESSION['user'])){ //c'est un admin qui ajoute un autre admin
            $profil = 'admin';
            $result = 1;
        }
        else{ //c'est un joueur qui s'inscrit
            $profil = 'joueur';
            $result = 2;
        }
        try{
            $db = connect_db();
            $query = $db -> prepare("INSERT INTO utilisateur(login, password, prenom, nom, profil) VALUES(:login, :password, :prenom, :nom, :profil)");
            $query -> bindParam("login",$login,PDO::PARAM_STR);
            $query -> bindParam("password",$password,PDO::PARAM_STR);
            $query -> bindParam("prenom",$prenom,PDO::PARAM_STR);
			$query -> bindParam("nom",$nom,PDO::PARAM_STR);
			$query -> bindParam("profil",$profil,PDO::PARAM_STR);
			$query -> execute();
			return $result;
            // return $db -> lastInsertId();
            }catch(PDOException $e){
            exit($e -> getMessage());
        }
    }
	/*---------------------------------------------------------
	Authentification des utilisateurs
	----------------------------------------------------------*/
	function connexion($login,$password){
		try{
			$db = connect_db();
            $query = $db -> prepare("SELECT * FROM utilisateur WHERE login=:login AND password=:password");
            $query->bindParam("login", $login, PDO::PARAM_STR);
            $query->bindParam("password", $password, PDO::PARAM_STR);
            $query -> execute();
			if($query -> rowCount() > 0){
				$user = $query -> fetch(PDO::FETCH_ASSOC);
				$profil = $user['PROFIL'];
				$_SESSION['user']=$user;
		 		$_SESSION['statut']='login';
			}
			if(isset($profil)){
				if($profil == 'admin'){
					return 'admin';
				}
				else{
					$_SESSION['questionsRepondues']= [];
		 			$_SESSION['questionsTrouvees'] = [];
		 			$_SESSION['pointsAccumules'] = 0;
					return 'joueur';
				}
			}
			else{
				return 'error';
			}
		}catch(PDOException $e){
			exit($e -> getMessage());
		}
	}

	/*---------------------------------------------------------
	supprimer un joueur
	----------------------------------------------------------*/
	function deleteUser($id){
		try{
			$db = connect_db();
			$query = $db -> prepare("DELETE FROM utilisateur WHERE id =: id");
			$query -> bindParam("id", $id, PDO::PARAM_INT);
			if($query -> execute()){
				$result = 1;
			}
			else{
				$result = 0;
			}
			return $result;
		}
		catch(PDOException $e){
			die("erreur: ".$e -> getMessage());
		}
	}
	/*------------------------------------
	Modifier les infos d'un joueur
	--------------------------------------*/ 
	function updateUser($id,$prenom,$nom,$login,$password){
		try{
			$db = connect_db;
			$query = $db -> prepare("UPDATE utilisateur SET prenom =: prenom, nom =: nom, login =: login,password =: password WHERE id =: id ");
			$query -> bindParam("prenom", $prenom, PDO::PARAM_STR);
			$query -> bindParam("nom", $nom, PDO::PARAM_STR);
			$query -> bindParam("login", $login, PDO::PARAM_STR);
			$query -> bindParam("password", $password, PDO::PARAM_STR);
			$query -> bindParam("id", $id, PDO::PARAM_INT);
			if($query -> execute()){
				$result = 1;
			}
			else{
				$result = 0;
			}
			return $result;
		}
		catch(PDOException $e){
			die("erreur: ".$e -> getMessage());
		}
	}

	/*------------------------------------
	envoyer la liste des joueurs
	--------------------------------------*/
	function listeJoueur($limit = 5, $offset = 1){
		try{
			$db = connect_db();
			$query = $db -> prepare("SELECT `utilisateur`.`ID`, `PRENOM`, `NOM`, `SCORE` FROM `utilisateur`,`joueur` WHERE `utilisateur`.`ID` = `joueur`.`ID` ORDER BY `joueur`.`SCORE` DESC LIMIT {$limit} OFFSET {$offset} ");
			$query -> execute();
			if($query -> rowCount() > 0){
				$result = $query -> fetchAll(PDO::FETCH_ASSOC);
				$result = json_encode($result);
			}
			else{
				$result = 0;
			}
			return $result;		
		}
		catch(PDOException $e){
			die("erreur: ".$e -> getMessage());
		}
	}

	/*------------------------------------
	Modifier info partielle utilisateur
	--------------------------------------*/
	function update_partial($table,$id,$val,$champ){
		try {
			$db = connect_db();
		$query = $db -> prepare("UPDATE `{$table}` SET `{$champ}` = '{$val}' WHERE `{$table}`.`ID` = {$id}");
			if ($query -> execute()) {
				return 'success';
			}
			else{
				return 'error';
			}
		}
		catch (PDOException $e) {
			die("erreur: ".$e);
		}
	}

	/*------------------------------------
	bloquer un utilisateur
	--------------------------------------*/
	function bloqueUser($table,$id){
		try {
			$db = connect_db();
		$query = $db -> prepare("UPDATE `{$table}` SET `ETAT` = 'bloque' WHERE `{$table}`.`ID` = {$id}");
			if ($query -> execute()) {
				return 'bloque';
			}
			else{
				return 'error';
			}
		}
		catch (PDOException $e) {
			die("erreur: ".$e);
		}
	}
?>