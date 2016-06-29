<?php
	function parseURL($pageName = null){
		if($pageName === null)
			$pageName = explode('/', Config::$baseDir)[1];
		
		$_GET = $_SERVER['REQUEST_URI'];
		$_GET = explode('/', $_GET);
		array_splice($_GET, 0, array_search($pageName, $_GET)+1);
		
	}
	
	function redirect($url, $message, $temps = 2, $type = "info"){
		header("refresh:$temps;url=$url");
		return '<div class="alert alert-dismissible alert-'.$type.'">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>'.$message.'</strong> <br/>
			Redirection en cours.<a href="'.$url.'" class="alert-link"> Si vous ne voulez pas attendre, cliquez ici.</a>
		</div>';
	}

?>