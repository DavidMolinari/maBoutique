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

$DBH = Connexion() ;

// r�cup�ration de l'�ventuel cookie
if (isset($_COOKIE["login"])) {
  $leId = ($_COOKIE["login"] + 27) / 353 ;
  //
   $curseur= $DBH->prepare("select * from client where numclient= :numclient");
   $curseur->bindParam(':numclient',$leId,PDO::PARAM_INT);
   $curseur->execute();
   $result = $curseur->fetch();

  if ($curseur->RowCount() !=0) {
    $_SESSION["login"] = $result['login'] ;
    $_SESSION["id"] = $result['numclient'] ;
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

function debug_to_console( $data ) {

    if ( is_array( $data ) )
        $output = "<script>alert( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>alert( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}

?>
