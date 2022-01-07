<?php
include_once('connexion.php');
if(is_numeric($_GET['search'])){
    $search 	= htmlspecialchars(strip_tags(trim($_GET["search"])));
		if(empty($search)){
			$error1 = "Que recherchez vous ?";
			$ok = false ;
		};  
    $searchOK = $mysqli->real_escape_string($search) ;

    $req = "SELECT * FROM serie WHERE id_serie = '$searchOK' ";
    $query = $mysqli->query($req) ;
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/starter.css">
	<link rel="stylesheet" type="text/css" href="css/design.css">
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
    <title>Votre série</title>
</head>
<body>
<?php
            while($row =$query->fetch_array()){
                echo "<h1>".$row["titre_serie"]."</h1>";
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
    echo "<div>".$row["synopsis_serie"]."</div>
    <button  type=\"button\" >
        <a href=\"afficher-series.php#".$row["id_serie"]."\">
            Retour
        </a>
    </button>   
    <button  type=\"button\" >
        <a href=\"supprimer-serie.php?search=".$row["id_serie"]."\">
           Supprimer
        </a>
    </button>   ";
    
        }
      
    

?>







</body>
</html>




