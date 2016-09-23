<?php include ("head.php") ;

  // initialisation des variables
  $nom = "" ;
  $prenom = "" ;
  $adr1 = "" ;
  $adr2 = "" ;
  $cp = "" ;
  $ville = "" ;
  $infoslivraison = "" ;
  $tel = "" ;
  $mail = "" ;
  $login = "" ;
  $mdp = "" ;
  $mdpverif = "" ;

  // v�rifie si la personne est connect�e
  if (isset($_SESSION["id"])) {
    // si elle est connect�e, r�cup�ration de ses informations personnelles
    $curseur = $DBH->prepare( "select * from client where numclient = :numclient");
    $curseur->bindParam(':numclient',$_SESSION["id"] );
    $curseur->execute();
    $result = $curseur->fetch();
    $nom = $result['nom'];
    $prenom = $result['prenom'] ;
    $adr1 = $result['adr1'];
    $adr2 = $result['adr2'];
    $cp = $result['cp'];
    $ville = $result['ville'];
    $infoslivraison = $result['infoslivraison'];
    $tel = $result['tel'];
    $mail = $result['mail'];
    $login = $result['login'];
    $mdp =  $result['mdp'];
    $mdpverif =  $result['mdp'];
    $message = "Bienvenue dans votre espace personnel.<br />Vous pouvez consulter, modifier vos informations et les enregistrer." ;


  }else{
    // si c'est une nouvelle personne, message personnalis� (et les variables restent vides)
    $message = "Bienvenue dans l'espace d'inscription.<br />Saisissez vos informations. Les zones avec * sont obligatoires." ;
  }

  ?>

  <!-- zone d'explication -->
  <div id="divExplication">
    <div class="petitTitre">ESPACE PERSONNEL</div><br />
    <div class="petitTexte">
      <?php echo $message ?>
    </div>
  </div>

  <!-- zone d'affichage des informations -->
  <div id="divPerso" class="petitTexte">
  <?php
    // affichage et saisie des informations de la personne
    $k = 0 ;
    $lesinfos = '<table id="tabPerso">' ;
    $lesinfos .= uneCase("login", "login", $login, 20, true) ;
    $lesinfos .= uneCase("mdp", "mot de passe", $mdp, 20, true, true) ;
    $lesinfos .= uneCase("mdpverif", "mot de passe (contr�le)", $mdpverif, 20, true, true) ;
    $lesinfos .= uneCase("nom", "nom", $nom, 30, true) ;
    $lesinfos .= uneCase("prenom", "prenom", $prenom, 30, true) ;
    $lesinfos .= uneCase("adr1", "adresse", $adr1, 50, true) ;
    $lesinfos .= uneCase("adr2", "compl�ment adresse", $adr2, 50) ;
    $lesinfos .= uneCase("cp", "code postal", $cp, 5, true) ;
    $lesinfos .= uneCase("ville", "ville", $ville, 30, true) ;
    $lesinfos .= uneCase("infoslivraison", "informations livraison", $infoslivraison, 50) ;
    $lesinfos .= uneCase("tel", "t�l�phone", $tel, 10) ;
    $lesinfos .= uneCase("mail", "adresse mail", $mail, 50) ;
    $lesinfos .= "</table>" ;
    echo $lesinfos ;
  ?>
</div>

<!-- zone d'affichage des factures -->
<div id="divSelection">
  <div class="petitTitre">vos factures</div><br />
  <div class="petitTexte">
    en construction<br />
    l'historique de vos factures apparaitra ici
  </div>
</div>

<!-- validation -->
<div id="divEnregistrer">
  <input id="cmdEnregistrer" type="button" value="Enregistrer" />
</div>

<?php include ("foot.php") ; ?>
