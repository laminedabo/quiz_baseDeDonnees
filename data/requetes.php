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

	function connexion($login,$password){
		try{
			$db = connect_db();
            $query = $db -> prepare("SELECT * FROM utilisateur WHERE login=:login AND password=:password");
            $query->bindParam("login", $login, PDO::PARAM_STR);
            $query->bindParam("password", $password, PDO::PARAM_STR);
            $query -> execute();
			if($query -> rowCount() > 0){
				$user = $query -> fetch(PDO::FETCH_ASSOC);
				$profil = $user['profil'];
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
?>