<?php
include_once('connexion.php');

if(isset($_POST['go'])){
    
    $nom	= htmlspecialchars(strip_tags(trim($_POST['nom'])));
    $email	= htmlspecialchars(strip_tags(trim($_POST['email'])));
    $pass	= htmlspecialchars(strip_tags(trim($_POST['pass'])));
    $ok = true;

    if(empty($nom)){
        $error1 = 'Quel est votre nom ?';
        $ok = false ;
    }
    if(empty($email)){
        $error2 = 'Entrez votre email  ?';
        $ok = false ;
    }
    if(empty($pass)){
        $error3 = 'Quel est votre identifiant ?';
        $ok = false ;
    }
    
    $nomOK = $mysqli->real_escape_string($nom) ;
    $emailOK=  $mysqli->real_escape_string($email) ;
    $passOK=  $mysqli->real_escape_string(hash('whirlpool',$pass)); 

    // on doit vérifier que le mail n'est pas déja inscris.
    $req1 = " SELECT * FROM user WHERE email_user = '$emailOK'";
    $query1 = $mysqli->query($req1) ;
    $nb = $query1->num_rows;
    // var_dump($query1, $nb);

    if($nb < 1){

    if($ok){
    $req = "INSERT INTO user VALUES (
        NULL,
        '$nomOK',
        '$emailOK',
        CURRENT_TIMESTAMP,
        1,
        '$passOK')";
    $query = $mysqli->query($req) ;
    $id_recu = $mysqli->insert_id ;


    // var_dump($query, $req) ;
    }
    if($id_recu > 0 ){
        header("Location: se-connecter.php");
    }
}else{
   $feedback = 'Email déja inscris';
}
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="<?php echo DOMAINE; ?>templates/front/js/jqueryUi/jquery-ui.js"></script>
    <script src="js/visuMdp.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <title>Inscription Webflix</title>
</head>
<body>
<h1> Inscrivez vous  </h1>
<form method="post" action="ajouter-user.php" enctype="multipart/form-data" >
<p>
    <label for="proposition">Nom </label>
    <input type="text" name="nom"  >
    <?php if(isset($error1)){echo "<p>".$error1."</p>";}?>

</p>
<p>
    <label for="proposition">Email  </label>
    <input type="email" name="email"  >
    <?php if(isset($error2)){echo "<p>".$error2."</p>";}?>

</p>
<p>
    <label for="proposition">Mot de passe </label>
    <input type="password" name="pass"  class="aide-mdp" >
    <?php if(isset($error3)){echo "<p>".$error3."</p>";}?>
    <?php if(isset($feedback)){echo "<p>".$feedback."</p>";}?>

</p>
<input type="submit" name="go" value="S'inscrire">
</form>
</body>
</html>




