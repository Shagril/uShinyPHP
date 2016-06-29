<?php
	
	class MultiModule1 extends MultiModule{
		
		public function __construct(){
			$name = 'MultiModule1';
			$displayName = 'MultiModule';
			$description = 'Premier MultiModule';
			$access = Array(1); // Mettre les droits ici (séparé par une virgule Valeur -1 pour empècher l'accès)
			
			Module::__construct($name, $displayName, $description, $access);
		}
		
		/***
		 * La Fonction getContent() est éxécuté lors de l'affichage du module 
		 * (renvoi une string au format html):
				public function getContent(){
					//Mettre le code de génération du html du module.
				}
		 ***/
		
		/***
		 * Possibilité de modifier l'apparence d'un boutons de module avec 
		 * la fonction (renvoi une string au format html): 
				public function button(){
					//Mettre le code html du bouton ici
				}
		 *
		 ***/
		 
		/*
		 * Possibilité de modifier la fonction de vérification des droits :
				public function hasAccess($accessTab){
					//Mettre le code ici.
				}
		 *
		 */
		
	}
	
	/*** 
	 * La ligne suivante est obligatoire pour passer la classe du module 
	 * au programme principal
	 ***/
	$module = new MultiModule1();
?>