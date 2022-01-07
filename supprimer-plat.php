<?php
session_start();
include_once('connexion.php');

if(isset($_SESSION['auth']['nom'] )){
if(is_numeric($_GET['id'])){
    $id 	= htmlspecialchars(strip_tags(trim($_GET["id"])));
		if(empty($id)){
			$error1 = "Que voullez vous supprimer ?";
			$ok = false ;
		};  
    $idOK = $mysqli->real_escape_string($id) ;
    $query = $mysqli->query($req) ;
    $req = "DELETE  FROM photo WHERE id_plat = '$idOK' ";
    $req = "DELETE  FROM plat WHERE id_plat = '$idOK' ";

    $query = $mysqli->query($req) ;

header('Location: accueil.php');
}
}else{
header('Location: accueil.php');
}