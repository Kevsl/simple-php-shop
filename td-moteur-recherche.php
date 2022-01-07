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

    $search 	= htmlspecialchars(strip_tags(trim($_POST["search"])));
                // enlève les caractère spéciaux, enlève les balise, et les espaces de $_POST["search"]

    $ok = true ;

    // -------------------------------------------------
	// ETAPE 3:  JE VERIFIE ET MESSAGES D'ERREURS
	// -------------------------------------------------
		if(empty($search)){
			$error1 = "Que recherchez vous ?";
			$ok = false ;
		};

		// -------------------------------------------------------------------------------
	// ETAPE 4:  SI PAS D ERREUR, 	ALOTS TRAITEMENT FINAL....  requetage SQL
	// -------------------------------------------------------------------------------
        
    $searchOK = $mysqli->real_escape_string($search) ;

        
    $req = "SELECT * FROM serie WHERE titre_serie LIKE '%$searchOK%' ";

    $query = $mysqli->query($req) ;

    $nb = $query->num_rows;

  


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
<h1> Quelle série recherchez vous ? </h1>

<form method="post" action="td-moteur-recherche.php" enctype="multipart/form-data" >
<p>
    <label for="proposition">Entrez le nom d'une série ? </label>
    <input type="text" name="search"  >
    <?php
    if(isset($error1)){echo "<p>".$error1." </p>"; }?>
</p>
<input type="submit" name="go" value="Poster">
<?php
if (!empty($_POST['search'])){
if(isset($nb)){
    
    echo "<p>Il y a ".$nb."séries à la location</p>";


if($nb > 0 ) {
while($row =$query->fetch_array()){
    // var_dump($row);


    echo "<h2>".$row["titre_serie"]."</h2>";
    if (empty($row["visuel_serie"])) {
        echo "<p>
        <img src =\"medias/nophoto.jpg\" alt=\"Pas de visuel \">
        </p>" ;
    }else{
        echo "<p>
        <img src=\"medias/".$row["visuel_serie"]."\" alt=\"Affiche de la série ".$row["titre_serie"]."\">
        </p>" ;
    }


    echo "<p> Nombre d'épisodes :".$row["nombre_episodes_serie"]."</p>
    <p> Prix la la location : ".$row["date_publication_serie"]."  </p>
    <h3> Synopsis </h3>";
    echo "<div>".$row["synopsis_serie"]."</div>";
        }
      }
    }
}
?>







</body>
</html>




