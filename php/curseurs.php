<?php

/**
 * Connexion à la base de données à partir de variables globales
 */     

		function Connexion(){
			global $bdServeur, $bdUser, $bdMdp, $bdBase ;
			
			$link = mysqli_connect($bdServeur, $bdUser, $bdMdp)
				or die("Erreur de connexion au serveur");
				
			mysqli_select_db($link, $bdBase)
				or die("Erreur sur le nom de la base de donnée");
		}

?>