<?php
	class Module{
		public static $listModule;
		
		private $_id;
		private $_name;
		private $_displayName;
		private $_description;
		private $_access;
		private $_dir;
		private $_url;
		
		public function __construct($name, $displayName, $description, $access){
			$this->_name = $name;
			if(isset($displayName))
				$this->_displayName = $displayName;
			else
				$this->_displayName = $name;
			$this->_description = $description;
			$this->_access = $access;
			$this->_url = Config::$baseDir;
		}
		
		public function show(){
			parseUrl($this->getName());
			if($this->hasAccess($_SESSION['access']))
				return $this->getContent();
			else
				return "Vous n'avez pas accès à cette page.";
		}
		
		public function getContent(){
			Logs::info('Module '.$this->_name.' loaded.');
			return 'Affichage du module '.$this->_name.'<br/>';
		}
		
		public function button(){
			if(in_array($this->_name, $_GET))
				return '<li class="active"><a data-toggle="tooltip" data-placement="bottom" title="'.$this->_description.'" href="'.$this->_url.'">'.$this->_displayName.'</a></li>';
			else
				return '<li><a data-toggle="tooltip" data-placement="bottom" title="'.$this->_description.'" href="'.$this->_url.'">'.$this->_displayName.'</a></li>';
		}
		
		public function hasAccess($accessTab){
			if(!in_array(-1, $this->_access)){
				foreach($accessTab as $access){
					if((in_array($access, $this->_access) || $access == 0)){
						return true;
					}
				}
			}
		
			return false;
		}
		
		public function getName(){
			return $this->_name;
		}
		
		public function getDisplayName(){
			return $this->_displayName;
		}
		
		public function setDir($dir){
			$this->_dir = $dir;
		}
		
		public function getDir(){
			return $this->_dir;
		}
		
		public function setUrl($url){
			$this->_url = $url;
		}
		
		public function getUrl(){
			return $this->_url;
		}
	}
?>