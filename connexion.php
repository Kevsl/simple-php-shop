<?php
//DEFINIR LES CONSTANTES DE CONNEXION A LA BDD
define("HOST", "localhost");
define("LOGIN", "root");
define("PASS", "");
define("BDD", "resto");

//MySQLi : une classe pour se connecter et agir sur une BDD
//Instanciation d'un nouvel objet de Connexion
$mysqli = @new MySQLi(HOST,LOGIN,PASS,BDD);

if($mysqli->connect_errno) {
	die("<p>Service indisponible !</p>");
}else{
	$mysqli->set_charset("utf8");
}

?>