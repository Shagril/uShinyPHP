<?php
	
	class GestionUtilisateur extends Module{
		
		public function __construct(){
			$name = 'GestionUtilisateur';
			$displayName = 'Gestion des Utilisateurs';
			$description = 'Module de Gestion des Utilisateurs.';
			$access = Array(1);
			
			Module::__construct($name, $displayName, $description, $access);
		}
		
		
	}
	
	$module = new GestionUtilisateur();
?>