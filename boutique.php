<?php include ("head.php") ; ?>

<div id="divExplication">
  <div class="petitTitre">BOUTIQUE</div><br />
  <div class="petitTexte">
    vous pouvez voir l'article en grand en passant la souris sur l'image<br />
    cliquez sur + pour ajouter l'article au panier<br />
    il n'y a qu'un exemplaire de chaque article vendu
  </div>
</div>

<div id="divArticles" class="petitTexte">
  <?php
    $k = 0 ;
    $lesarticles = '<table id="tabArticles">' ;       // tableau de gauche
    $laselection = '<table id="tSelection">' ;        // tableau de droite
    $chemin = "images/articles/" ;
    $flux = dir($chemin) ;
    while ($fic = $flux->read()) {
      // v�rifie si l'article est d�j� pr�sent dans le panier
      $articlePresent = false ;
      if (isset($_SESSION["id"])) {

        $curseur= $DBH->prepare("select * from panier where idclient= :idclient and idarticle= :idarticle");
        $curseur->bindParam(':idclient',$_SESSION["id"]);
        $curseur->bindParam(':idarticle',$k);

        $curseur->execute();
        $result = $curseur->fetch();
        $articlePresent = ($curseur->rowCount()!=0) ;
      }
      // parcours des fichiers des articles dans le dossier
      $ficComplet = $chemin.$fic ;
      // si le fichier est une image
      if ($fic!="." && $fic!=".." && exif_imagetype ($ficComplet)) {
        $nom = substr($fic,0,strlen($fic)-4) ;
        // r�cup�ration des informations du fichier image
        $infos = exif_read_data($ficComplet, 0, true) ;
        $titre = enleveUnSurDeux($infos["IFD0"]["Title"]) ;
        $sujet = enleveUnSurDeux($infos["IFD0"]["Subject"]) ;
        $commentaire = enleveUnSurDeux($infos["IFD0"]["Comments"]) ;
        // construction de la ligne de gauche
        $lesarticles .= '<tr>' ;
        $lesarticles .= '<td class="td1"><img id="img'.$k.'" src="'.$ficComplet.'" alt="'.$titre.'" class="imgBoutique" /></td>' ;
        $lesarticles .= '<td class="td2">'.$titre.'<br />'.$commentaire.'</td>' ;
        $lesarticles .= '<td class="td3"><label id="lbl'.$k.'">'.$sujet.'</label>�</td>' ;
        if ($articlePresent) {
          $lesarticles .= '<td class="td4"><img id="ajout'.$k.'" src="images/plus.jpg" alt="ajouter" style="visibility:hidden" /></td>' ;
        }else{
          $lesarticles .= '<td class="td4"><img id="ajout'.$k.'" src="images/plus.jpg" alt="ajouter" /></td>' ;
        }
        $lesarticles .= '</tr>' ;
        // construction de la ligne dans le r�capitulatif si panier en cours
        if ($articlePresent) {
          $laselection .= '<tbody id="b'.$k.'"><tr>' ;
          $laselection .= '<td>'.$titre.'</td>' ;
          $laselection .= '<td>'.$sujet.'�</td>' ;
          $laselection .= '<td><img id="corb'.$k.'" src="images/corbeille.jpg" alt="supprimer" style="cursor:pointer" /></td>' ;
          $laselection .= '</tr><tbody>' ;
        }
        $k++ ;
      }
    }
    $flux->close() ;
    $lesarticles .= "</table>" ;
    $laselection .= "</table>" ;
    echo $lesarticles ;
  ?>
</div>

<div id="divSelection">
  <div class="petitTitre">votre s�lection</div><br />
  <div class="petitTexte">
    <?php echo $laselection ?>
  </div>
</div>

<div id="divVisuel"></div>

<?php include ("foot.php") ; ?>
