<?php
	
	class Administration extends MultiModule{
		
		public function __construct(){
			$name = 'Administration';
			$displayName = 'Administration';
			$description = 'Module d\'Administration';
			$access = Array(1);
			
			Module::__construct($name, $displayName, $description, $access);
		}
		
	}
	
	$module = new Administration();
?>