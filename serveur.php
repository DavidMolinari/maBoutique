<?php
include_once("php/init.php") ;

//--- demande et contr�le d'identification ---
if (isset($_GET["txtLogin"])) {
  $login = $_GET["txtLogin"] ;
  $mdp = $_GET["pwdMdp"] ;

  // Passage en PDO pour les requêtes SQL
  $curseur = $DBH->prepare( "select * from client where login= :login and mdp = :mdp");
  $curseur->bindParam(':login',$login,PDO::PARAM_STR );
  $curseur->bindParam(':mdp',$mdp,PDO::PARAM_STR );
  $curseur->execute();
  $result = $curseur->fetch();

  if ($curseur->rowCount() !=0) {
    $_SESSION["login"] = $login ;
    $_SESSION["id"] = $result['numclient'];
    setcookie("login", $_SESSION["id"] * 353 - 27, time()+60*60*24*3600) ;
    echo $login ;
  }else{
    echo "" ;
  }
//--- enregistrement de la couleur du tshirt ---
}elseif (isset($_POST["couleur"])) {
  $_SESSION["couleur"] = $_POST["couleur"] ;

//--- controle si une couleur de tshirt a �j� �t� s�lectionn�e ---
}elseif (isset($_GET["tshirt"])) {
  if (isset($_SESSION["couleur"])) {
    echo $_SESSION["couleur"] ;
  }else{
    echo "" ;
  }

//--- supprimer l'enregistrement de la couleur du tshirt ---
}elseif (isset($_POST["supprtshirt"])) {
  session_unregister("couleur") ;

//--- insertion d'un article dans le panier (si la personne est identifi�e) ---
}elseif (isset($_POST["panierplus"])) {
  if (isset($_SESSION["id"])) {
	$query = $DBH->prepare("insert into panier values( :id, :panierplus)");
	$query->bindParam(':id',$_SESSION["id"],PDO::PARAM_INT );
	$query->bindParam(':panierplus',$_POST["panierplus"],PDO::PARAM_INT );
	$query->execute();
  }

//--- suppression d'un article du panier (si la personne est identifi�e) ---
}elseif (isset($_POST["paniermoins"])) {
  if (isset($_SESSION["id"])) {
	$query = $DBH->prepare("delete from panier where idclient= :id and idarticle= :paniermoins");
	$query->bindParam(':id',$_SESSION["id"],PDO::PARAM_INT);
	$query->bindParam(':paniermoins',$_POST["paniermoins"],PDO::PARAM_INT);
	$query->execute();

  }

//--- contr�le si le login saisi n'existe pas d�j� ---
}elseif (isset($_GET["controle"])) {
  $login = $_GET["controle"] ;
  $curseur = $DBH->prepare( "select * from client where login= :login");
  $curseur->bindParam(':login', $login,PDO::PARAM_STR);
  $curseur->execute();
  $result = $curseur->fetch();
  if ($curseur->rowCount()==0) {
    echo "faux" ;
  }elseif (!isset($_SESSION["id"])) {
    echo "vrai" ;
  }elseif ($_SESSION["id"]!=$result['numclient']) {
    echo "vrai" ;
  }else{
    echo "faux" ;
  }

//--- enregistrement des informations de la personne ---
}elseif (isset($_GET["login"])) {
  // r�cup�ration de toutes les informations
  $nom = $_GET["nom"] ;
  $prenom = $_GET["prenom"] ;
  $adr1 = $_GET["adr1"] ;
  $adr2 = $_GET["adr2"] ;
  $cp = $_GET["cp"] ;
  $ville = $_GET["ville"] ;
  $infoslivraison = $_GET["infoslivraison"] ;
  $tel = $_GET["tel"] ;
  $mail = $_GET["mail"] ;
  $login = $_GET["login"] ;
  $mdp = $_GET["mdp"] ;


  // ajoute ou modifie (suivant si la personne existe ou non)
  if (isset($_SESSION["id"])) {
  $id = $_SESSION["id"] ;

	$requete = $DBH->prepare("update CLIENT SET nom= :nom, prenom = :prenom,adr1= :adr1, adr2= :adr2, cp= :cp, ville= :ville, infoslivraison= :infoslivraison, tel= :tel, mail= :mail, login= :login, mdp= :mdp where numclient= :numclient");
	$requete->bindParam(':nom',$nom,PDO::PARAM_STR);
	$requete->bindParam(':prenom',$prenom ,PDO::PARAM_STR);
	$requete->bindParam(':adr1',$adr1 ,PDO::PARAM_STR);
	$requete->bindParam(':adr2',$adr2 ,PDO::PARAM_STR);
	$requete->bindParam(':cp',$cp ,PDO::PARAM_STR);
	$requete->bindParam(':ville',$ville ,PDO::PARAM_STR);
	$requete->bindParam(':infoslivraison',$infoslivraison ,PDO::PARAM_STR);
	$requete->bindParam(':tel',$tel ,PDO::PARAM_STR);
	$requete->bindParam(':mail',$mail ,PDO::PARAM_STR);
	$requete->bindParam(':login',$login ,PDO::PARAM_STR);
	$requete->bindParam(':mdp',$mdp ,PDO::PARAM_STR);
	$requete->bindParam(':numclient',$id ,PDO::PARAM_INT);
	$requete->execute();
	$result = $requete->fetch();


  }else{
    $requete = $DBH->prepare('insert into client values (:numclient, :nom, :prenom, :adr1, :adr2, :cp, :ville, :infoslivraison, :tel, :mail, :login, :mdp)') ;
	$requete->bindParam(':nom',$nom ,PDO::PARAM_STR);
	$requete->bindParam(':prenom',$prenom,PDO::PARAM_STR );
	$requete->bindParam(':adr1',$adr1,PDO::PARAM_STR );
	$requete->bindParam(':adr2',$adr2 ,PDO::PARAM_STR);
	$requete->bindParam(':cp',$cp ,PDO::PARAM_STR);
	$requete->bindParam(':ville',$ville,PDO::PARAM_STR );
	$requete->bindParam(':infoslivraison',$infoslivraison,PDO::PARAM_STR );
	$requete->bindParam(':tel',$tel ,PDO::PARAM_STR);
	$requete->bindParam(':mail',$mail ,PDO::PARAM_STR);
	$requete->bindParam(':login',$login,PDO::PARAM_STR );
	$requete->bindParam(':mdp',$mdp ,PDO::PARAM_STR);
    $id = $DBH->lastInsertId();
	$requete->bindParam(':numclient', $id ,PDO::PARAM_INT);
	$requete->execute();
	$result = $requete->fetch();

  }

  // met � jour les variables de session et le cookie
  $_SESSION["login"] = $login ;
  $_SESSION["id"] = $id ;
  setcookie("login", $id * 353 - 27, time()+60*60*24*3600) ;

}else{
  // demande de d�connexion
  session_unregister("login") ;
  session_unregister("id") ;
  setcookie("login", "", time() - 3600) ;
}

?>
