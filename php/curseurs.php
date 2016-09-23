<?php

/**
 * Connexion � la base de donn�es � partir de variables globales
 */     

    function Connexion(){
	global $bdServeur, $bdUser, $bdMdp, $bdBase ;			
	try {
            $DBH = new PDO("mysql:host=$bdServeur;dbname=$bdBase", $bdUser, $bdMdp);
                            }
        catch(PDOException $e) {
            echo $e->getMessage();
            }
				
	return $DBH;
	}
		
		

?>