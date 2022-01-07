<?php
include_once('connexion.php');
if(is_numeric($_GET['search'])){
    $search 	= htmlspecialchars(strip_tags(trim($_GET["search"])));
		if(empty($search)){
			$error1 = "Que recherchez vous ?";
			$ok = false ;
		};  
    $searchOK = $mysqli->real_escape_string($search) ;
    $req = "DELETE  FROM serie_has_genre WHERE id_serie = '$searchOK' ";
    $query = $mysqli->query($req) ;
    $req = "DELETE  FROM serie WHERE id_serie = '$searchOK' ";
    $query = $mysqli->query($req) ;

header('Location: afficher-series.php');
}
?>










