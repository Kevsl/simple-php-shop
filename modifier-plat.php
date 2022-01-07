<?php
include_once('connexion.php');
// ------------------------------------------
// ETAPE 1:  Si le form a été posté
// ------------------------------------------

if (isset($_POST['go'])) {
    // $_POST : une variable , une super globale ( portée supérieure aux var simples)typée tableau associatif. Crée automatiquement par le serveur, lorsque celui ci reçoit les datas d'un form method post.

    // -------------------------------------------------------------------------------
    // ETAPE 2:  JE VENTILE LES DATAS RECUS EN ENLEVANT ESPACE ET CARACTERES SPECIAUX
    // ------------------------------------------------------------------------------

    $plat    = htmlspecialchars(strip_tags(trim($_POST['nom'])));
    $prix    = htmlspecialchars(strip_tags(trim($_POST['prix'])));
    $quantite    = htmlspecialchars(strip_tags(trim($_POST['quantite'])));

    $target_dir = "medias/";
    $target_file = $target_dir . basename($_FILES["visuel"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    //Check if image file is a actual image or fake image

    $check = getimagesize($_FILES["visuel"]["tmp_name"]);
    if (!empty($check)) {
        $uploadOk = 1;
    } else {        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["visuel"]["size"] > 9000000) {
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        $uploadOk = 0;
    }

    //   Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["visuel"]["tmp_name"], $target_file)) {
        } else {
        }
    }



    $visuel = $_FILES["visuel"]["name"];




    $plat = $mysqli->real_escape_string($plat);
    $prix =  $mysqli->real_escape_string($prix);
    $quantite =  $mysqli->real_escape_string($quantite);
    $visuel = $mysqli->real_escape_string($visuel);

    $req = "INSERT INTO plat VALUES (
        NULL,
        '$plat',
        '$quantite',
        '$prix'
       )
         ";
    $query = $mysqli->query($req);

    $insert_id = $mysqli->insert_id;
   

    $req2 = "INSERT INTO photo VALUES (
        NULL,
        '$visuel',
        '$insert_id' )";
    $query2 = $mysqli->query($req2);
    header('Location: accueil.php');      

}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un plat</title>
</head>

<body>
    <h1> Ajouter un plat </h1>

    <form method="post" action="ajouter-plat.php" enctype="multipart/form-data">
        <p>
            <label for="proposition">Nom plat </label>
            <input type="text" name="nom">
        </p>
        <p>
            <label for="proposition">prix ? </label>
            <input type="number" name="prix">
        </p>
        <p>
            <label for="proposition">Quantité ? </label>
            <input type="number" name="quantite">
        </p>
        <p>
            <label for="proposition"> photo ? </label>
            <input type="file" name="visuel">
        </p>


        <input type="submit" name="go" value="Poster">







</body>

</html>