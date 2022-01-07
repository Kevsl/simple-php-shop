<?php
session_start();
// On démarre une session utilisateur
include_once('connexion.php');
	// ------------------------------------------
	// ETAPE 1:  Si le form a été posté
	// ------------------------------------------

if(isset($_POST['go'])){
    	

    $login 	= htmlspecialchars(strip_tags(trim($_POST["login"])));
    $pass 	= htmlspecialchars(strip_tags(trim($_POST["pass"])));

                // enlève les caractère spéciaux, enlève les balise, et les espaces de $_POST["login & pass"]

    $ok = true ;

    // -------------------------------------------------
	// ETAPE 3:  JE VERIFIE ET MESSAGES D'ERREURS
	// -------------------------------------------------
		if(empty($login)){
			$error1 = "Entrez un login ou votre numéro de cb 
             ou j'appelle la police ";
			$ok = false ;
		};
        if(empty($pass)){
			$error2 = "N'insistez pas ! la police arrive";
			$ok = false ;
		};

		// -------------------------------------------------------------------------------
	// ETAPE 4:  SI PAS D ERREUR, 	ALOTS TRAITEMENT FINAL....  requetage SQL
	// -------------------------------------------------------------------------------
       if($ok){   
    $loginOK = $mysqli->real_escape_string($login) ;
    $passOK = $mysqli->real_escape_string(hash('whirlpool',$pass)) ;
        
    $req = "SELECT * FROM user WHERE email_user = '$loginOK'
    AND password_user = '$passOK' ";

    $query = $mysqli->query($req) ;
    $nb = $query->num_rows;
       

   
    if(!is_null($query)){
            while($row = $query->fetch_array()){
            $_SESSION['auth']['id'] = $row['id_user'];
            $_SESSION['auth']['nom'] = $row['nom_user'];

            }
           
          header('Location: accueil.php');   
           

            
        }
        if($nb>1){
            header('Location: 404.html');
        }else{
            $feedback = ' Pas de compte associé à cet email';
        }
      
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter sur Webflix</title>
</head>

<body>
    <h1> Le paradis des cartes bleues </h1>

    <form method="post" action="connexion-user.php" enctype="multipart/form-data">
        <p>
            <label for="proposition">Login: </label>
            <input type="email" name="login">
            <?php if(isset($error1)){echo "<p>".$error1." </p>"; }?>
        </p>
        <p>
            <label for="proposition">Mot de passe: </label>
            <input type="password" name="pass">
            <?php if(isset($error2)){echo "<p>".$error2." </p>"; }?>
        </p>
        <input type="submit" name="go" value="Se connecter">
        <?php if(isset($feedback)){echo "<p>".$feedback." </p>"; }?>


    </form>
</body>

</html>