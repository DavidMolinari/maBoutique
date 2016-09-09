<?php

session_start () ;

// variables globales
$bdServeur = "localhost" ;
$bdUser = "root" ;
$bdMdp = "" ;
$bdBase = "boutique" ; 
$prixTshirt = 25 ;

// inclusion des autres fichiers
include_once ("chaines.php") ;
include_once ("curseurs.php") ;
include_once ("outils.php") ;

$link = Connexion() ;

// r�cup�ration de l'�ventuel cookie
if (isset($_COOKIE["login"])) {
  $leId = ($_COOKIE["login"] + 27) / 353 ;
  $curseur = mysqli_query($link, "select * from client where numclient=".$leId) ;
  if (mysqli_num_rows($curseur)!=0) {
    $_SESSION["login"] = mysqli_result($curseur, 0, "login") ;
    $_SESSION["id"] = mysqli_result($curseur, 0, "numclient") ;
  }
}

// r�cup�ration des variables de session �ventuelles
if (isset($_SESSION["login"])) {
  $login = $_SESSION["login"] ;
  $id = $_SESSION["id"] ;  
}else{
  $login = "" ;
  $id = "" ;
}

?>