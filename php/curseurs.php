<?php

/**
 * Connexion � la base de donn�es � partir de variables globales
 */     

		function Connexion(){
			global $bdServeur, $bdUser, $bdMdp, $bdBase ;
			
			$link = mysqli_connect($bdServeur, $bdUser, $bdMdp)
				or die("Erreur de connexion au serveur");
				
			mysqli_select_db($link, $bdBase)
				or die("Erreur sur le nom de la base de donn�e");
				
				return $link;
		}
		
		function mysqli_result($res, $row, $field=0) { 
    $res->data_seek($row); 
    $datarow = $res->fetch_array(); 
    return $datarow[$field]; 
}

?>