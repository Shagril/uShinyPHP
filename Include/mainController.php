<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	ini_set('session.save_handler', 'user');//on définit l'utilisation des sessions en personnel
	
	include_once('./Include/Config.php');
	include_once('./Include/Functions/logs.php');
	include_once('./Include/Functions/DAO.php');
	
	Logs::init();

	include_once('./Include/Functions/security.php');
	
	$session = new Session();//on déclare la classe

	session_set_save_handler(array($session, 'open'),
							 array($session, 'close'),
							 array($session, 'read'),
							 array($session, 'write'),
							 array($session, 'destroy'),
							 array($session, 'gc'));//on précise les méthodes à employer pour les sessions

	session_start();//on démarre la session
	
	if(!isset($_SESSION['user'])){
		$_SESSION['tooken'] = generate_tooken();
		$_SESSION['user'] = null;
		$_SESSION['pseudo'] = null;
		$_SESSION['email'] = null;
		$_SESSION['access'] = Array();
	}
	
	
	/* Récupères les informations de l'URL (dans le $_GET) */
	include_once('./Include/Functions/URL.php');
	parseURL();
	
	include_once('./Include/Modules.php');
	include_once('./Include/MultiModule.php');
	
	Module::$listModule = Array();
	
	$header = '';
	$nav = '';
	$rightNav = '';
	$content = '';
	$footer = '';
	
	
	$found = false;
	
	if($_SERVER['REQUEST_URI'] == Config::$baseDir){
		$found = true;
		include('./Include/home.php');
	}
	
	
	$directory = './Modules/';
	
	foreach(array_diff(scandir($directory), array('..', '.')) as $dossierDir){
		if(is_dir($directory.$dossierDir))
		{
			include_once($directory.$dossierDir.'/index.php');
			
			Module::$listModule[$module->getName()] = $module;
			
			$module->setDir($directory.$dossierDir);
			$module->setUrl(Config::$baseDir.$module->getName());
			
			if($module->hasAccess($_SESSION['access']))
				$nav .= $module->button();
			if(isset($_GET[0]) && strtolower($_GET[0]) == strtolower($module->getName())){
				parseUrl($module->getName());
				$found = true;
				$content = $module->show();
			}
		}
	}
	
	if(!$found)
		include_once('./Error/404.php');
	if($content != null)
		include_once('./Include/vue.php');
?>