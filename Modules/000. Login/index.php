<?php

	class ModuleLogin extends Module{

		public function __construct(){
			$name = 'Login';
			$displayName = 'Login Module';
			$description = 'Ce Module permet à un utilisateur de ce connecter sur le site.';
			$access = Array(-1); /* Personne ne peut voir ce module (PS: Modification de la 
								  * fonction show pour pouvoir y accéder même si l'on ne
								  * peut pas le voir. 
								  * ! Cela empêche l'appel de la fonction getContent. ) */
			
			Module::__construct($name, $displayName, $description, $access);
		}

		
		public function show(){
			parseUrl();
			if(isset($_POST['login']) && !empty($_POST['login'])){
				$db = DAO::connect();
				
				$query = $db->prepare('SELECT * FROM view_user WHERE pseudo = :login AND password = :password');
				$query->execute(Array(
					'login'=>$_POST['login'],
					'password'=>crypt($_POST['password'], Config::$crypt)
				));
				
				if($data = $query->fetch()){
					$_SESSION['user'] = $data['id'];
					$_SESSION['pseudo'] = $data['pseudo'];
					$_SESSION['email'] = $data['email'];
					$_SESSION['access'] = explode(',', $data['access']);
					
					return redirect($_POST['lastLocation'], 'Login en cours.');
				}else{
					return redirect('./login', 'Mot de passe erroné.');
				}
			}else{
				$lastLocation = $_SERVER['REQUEST_URI'];
				
				if(isset($_POST['lastLocation']))
					$lastLocation = $_POST['lastLocation'];
				
				if(isset($_GET[1]) && $_GET[1] == 'logout')
				{
					session_unset();
					session_destroy();
					
					return redirect($_POST['lastLocation'], 'Déconnexion en cours.');
				}else{
					return '
						<form class="form-horizontal" action="'.Config::$baseDir.'login" method="post">
							<h1>Connexion</h1>
							<div class="form-group">
								<label class="control-label" for="login">Login</label>
								<input class="form-control" name="login" id="login"></input>
							</div>
							
							<div class="form-group">
								<label class="control-label" for="password">Password</label>
								<input class="form-control" name="password" id="Password" type="password"></input>
							</div>

							<input type="hidden" name="lastLocation" value="'.$lastLocation.'"></input>
							<br/>
							<input type="reset" class="btn btn-default"></input>
							<input type="submit" class="btn btn-primary" id="action" name="action" value="Se Connecter"></input>
						</form>
					';
				}
			}
		}

		public function button(){
			
			if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
				return '
					<li>
						<form class="navbar-form" role="logout" action="'.Config::$baseDir.'login/logout" method="POST">
							<input type="hidden" name="lastLocation" value="'.$_SERVER['REQUEST_URI'].'"></input>
							<input class="btn btn-primary" type="submit" name="action" value="Déconnexion"></input>
						</form>
					</li>
				';
			}
			else
			{
				
				$lastLocation = $_SERVER['REQUEST_URI'];
				
				if(isset($_POST['lastLocation']))
					$lastLocation = $_POST['lastLocation'];
				
				
				return '
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Login <span class="caret"></span></a>
						<ul class="dropdown-menu connexion-panel" role="menu">
							<form class="form-horizontal" action="'.Config::$baseDir.'login" method="post">
								<h1>Connexion</h1>
								<div class="form-group">
									<label class="control-label sr-only" for="login">Login</label>
									<input class="form-control" name="login" id="login" placeholder="Login"></input>
								</div>

								<div class="form-group">
									<label class="control-label sr-only" for="password">Password</label>
									<input class="form-control" name="password" id="password" type="password" placeholder="Password"></input>
								</div>

								<input type="hidden" name="lastLocation" value="'.$lastLocation.'"></input>
								<br/>
								<input type="reset" class="btn btn-default"></input>
								<input type="submit" class="btn btn-primary" id="action" name="action" value="Se Connecter"></input>
							</form>
						</ul>
					</li>
				';
			}
		}

	}

	$module = new ModuleLogin();

	/***
	 * Permet d'avoir le bouton de login à droite de la page au lieu d'un bouton normal.
	 ***/
	if(strtolower($_GET[0]) != strtolower($module->getName()))
		$rightNav .= $module->button();

?>