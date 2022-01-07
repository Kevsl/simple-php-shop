<?php
include_once('connexion.php');
	// ------------------------------------------
	// ETAPE 1:  Si le form a été posté
	// ------------------------------------------

if(isset($_POST['go'])){
    // $_POST : une variable , une super globale ( portée supérieure aux var simples)typée tableau associatif. Crée automatiquement par le serveur, lorsque celui ci reçoit les datas d'un form method post.

    	// -------------------------------------------------------------------------------
		// ETAPE 2:  JE VENTILE LES DATAS RECUS EN ENLEVANT ESPACE ET CARACTERES SPECIAUX
		// ------------------------------------------------------------------------------

    $titre	= htmlspecialchars(strip_tags(trim($_POST['titre'])));
    $synopsis	= htmlspecialchars(strip_tags(trim($_POST['synopsis'])));
    $nb_episode	= htmlspecialchars(strip_tags(trim($_POST['nb_episode'])));
    $public = htmlspecialchars(strip_tags(trim($_POST['public'])));

    $target_dir = "medias/";
$target_file = $target_dir.basename($_FILES["visuel"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
//Check if image file is a actual image or fake image

  $check = getimagesize($_FILES["visuel"]["tmp_name"]);
  if(!empty($check)) {
    echo "File is an image - ".$check["mime"].".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
// Check file size
if ($_FILES["visuel"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }
  
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }
  
//   Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["visuel"]["tmp_name"], $target_file)) {
      echo "The file ". htmlspecialchars(basename( $_FILES["visuel"]["name"])). " has been uploaded.";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }


  
$visuel = $_FILES["visuel"]["name"];
  var_dump($_FILES,$target_file);


                // enlève les caractère spéciaux, enlève les balise, et les espaces de $_POST["search"]

  

    // -------------------------------------------------
	// ETAPE 3:  JE VERIFIE ET MESSAGES D'ERREURS
	// -------------------------------------------------
		

		// -------------------------------------------------------------------------------
	// ETAPE 4:  SI PAS D ERREUR, 	ALOTS TRAITEMENT FINAL....  requetage SQL
	// -------------------------------------------------------------------------------
        
    $titreOK = $mysqli->real_escape_string($titre) ;
    $synopsysOK=  $mysqli->real_escape_string($synopsis) ;
    $nb_episodeOK=  $mysqli->real_escape_string($nb_episode); 
    $visuelOK = $mysqli->real_escape_string($visuel) ;
    $publicOK = $mysqli->real_escape_string($public); 
        
    $req = "INSERT INTO serie VALUES (
        null,
        '$titreOK',
        '$synopsysOK',
        '$nb_episodeOK',
        CURRENT_TIMESTAMP,
        '$visuelOK',
        '$publicOK')
         ";
        

    $query = $mysqli->query($req) ;
        // header("Location: afficher-series.php");
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toutes nos séries disponibles</title>
</head>
<body>
<h1> Ajouter une série </h1>

<form method="post" action="ajouter-serie" enctype="multipart/form-data" >
<p>
    <label for="proposition">Titre de la série </label>
    <input type="text" name="titre"  >
</p>
<p>
    <label for="proposition">Synopsis  ? </label>
    <input type="textarea" name="synopsis"  >
</p>
<p>
    <label for="proposition">Nombre d'épisodes ? </label>
    <input type="text" name="nb_episode"  >
</p>
<p>
    <label for="proposition"> photo ? </label>
    <input type="file" name="visuel"  >
</p>
<select name="public" id="nom-original">
    <option value="1">Tout public</option>
    <option value="2">Moins de 12 ans </option>
    <option value="3">Moins de 16 ans</option>
    <option value="4">Moins de 18 ans </option>
    <option value="5">Plus de 80 ans</option>
</select>    

<input type="submit" name="go" value="Poster">
<?php


?>







</body>
</html>




