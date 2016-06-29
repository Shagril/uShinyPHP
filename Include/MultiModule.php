<?php
	
	class MultiModule extends Module{
		private $listSubModule;
		
		/***
		 * La Fonction getContent() est éxécuté lors de l'affichage du module (renvoi une string au format html).
		 ***/
		 public function getContent(){
			foreach($this->listSubModule as $module){
				if(isset($_GET[0]) && strtolower($_GET[0]) == strtolower($module->getName())){
					$content = $module->show();
					$found = true;
					return $content;
				}
			}
		 }
		
		public function button(){
			//TODO: Permettre d'afficher un multimodule dans un autre multimodule
			$this->listSubModule = Array();
			
			$nav = '';
			
			$found = false;
			
			$directory = self::getDir().'/Modules/';
			
			foreach(array_diff(scandir($directory), array('..', '.')) as $dossierDir){
				if(is_dir($directory.$dossierDir))
				{
					include_once($directory.$dossierDir.'/index.php');
					
					$this->listSubModule[$module->getName()] = $module;
					
					$module->setDir($directory.$dossierDir);
					$module->setUrl(self::getUrl().'/'.$module->getName());
					
					if($module->hasAccess($_SESSION['access']))
						$nav .= $module->button();
				}
			}
			
			if(!$found)
				include_once('./Error/404.php');
	
			$active = '';
			if(in_array(self::getName(), $_GET))
				$active = 'active';
			
			return '
					<li class="dropdown '.$active.'">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">'.self::getDisplayName().'<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							'.$nav.'
						</ul>
					</li>
				';
		}
		
	}
?>