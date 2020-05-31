<?php
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
	function addUser($login,$password,$prenom,$nom)
    {
        try{
            $db = connect_db();
            $query = $db -> prepare("INSERT INTO utilisateur(login, password, prenom, nom) VALUES(:login, :password, :prenom, :nom)");
            $query -> bindParam("login",$login,PDO::PARAM_STR);
            $query -> bindParam("password",$password,PDO::PARAM_STR);
            $query -> bindParam("prenom",$prenom,PDO::PARAM_STR);
            $query -> bindParam("nom",$nom,PDO::PARAM_STR);
            $query -> execute();
            return $db -> lastInsertId();
            }catch(PDOException $e){
            exit($e -> getMessage());
        }
    }

	function connexion($login,$password){
		try{
			$db = connect_db();
            $query = $db -> prepare("SELECT * FROM utilisateur WHERE login=:login AND password=:password");
            $query->bindParam("login", $login, PDO::PARAM_STR);
            $query->bindParam("password", $password, PDO::PARAM_STR);
            $query -> execute();
			if($query -> rowCount() > 0){
				return $query -> fetch(PDO::FETCH_ASSOC);				
			}
			if(isset($profil)){
				$_SESSION['user']=['dd','ee'];
		 		$_SESSION['statut']='login';
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
?>