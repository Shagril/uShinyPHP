<?php
	echo('
		Installation en cours... <br/>
		Veuillez Patienter. <br/>
	');
	
	if(isset($_POST['action']) && !empty($_POST['action'])){
		
		
		$host = $_POST['host'];
		$dbname = $_POST['dbname'];
		$user = $_POST['user'];
		$password  = $_POST['password'];

		$db = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $user, $password);
		
		$query = $db->exec("
			CREATE TABLE IF NOT EXISTS `session` (
				`user_id` int(11) DEFAULT NULL,
				`sess_id` char(40) NOT NULL PRIMARY KEY,
				`sess_datas` text NOT NULL,
				`sess_expire` bigint(20) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;
			
			CREATE TABLE IF NOT EXISTS `user` (
				`id` int(11) NOT NULL PRIMARY KEY,
				`pseudo` varchar(64) NOT NULL,
				`nom` varchar(64),
				`prenom` varchar(64),
				`password` varchar(128) NOT NULL,
				`email` varchar(128) DEFAULT NULL,
				`access` varchar(32) DEFAULT NULL,
				`archive` tinyint(1) NOT NULL DEFAULT '0'
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Table enregistrant les comptes utilisateurs.';
			
			CREATE OR REPLACE VIEW `view_user` AS (
				SELECT 	`u`.`id` AS `id`,
						`u`.`pseudo` AS `pseudo`,
						`u`.`password` AS `password`,
						`u`.`nom` AS `nom`,
						`u`.`prenom` AS `prenom`,
						`u`.`email` AS `email`,
						`u`.`access` AS `access`
				FROM `user` `u`
				WHERE `u`.`archive` <> TRUE
			);
		");
		
		$query = $db->prepare('
			REPLACE INTO user(
				id,
				pseudo,
				password,
				email,
				access
			)VALUES(
				1,
				:pseudo,
				:password,
				"admin@local.fr",
				"1"
			)
		');
		
		$query->execute(Array(
			"pseudo"=>$_POST['pseudo'],
			"password"=>crypt($_POST['mdp'], $_POST['crypt'])
		));
		
		$uploaddir = 'Include/Resources/img/logo/';
		$uploadfile = '../'.$uploaddir . basename($_FILES['logo']['name']);
		
		if (!move_uploaded_file($_FILES['logo']['tmp_name'], $uploadfile)){
			echo "Erreur. <br/>
				  Voici plus d'informations :\n";
			print_r($_FILES);
		}
		switch($_POST['theme']){
			case 1:
				$theme = $_POST['uri'].'Include/Resources/css/bootstrap.min.css';
				break;
			case 2:
				$theme = $_POST['uri'].'Include/Resources/css/bootstrap-material.min.css';
				break;
		}
		
		$file = fopen('../Include/Config.php', 'w');
		
		fseek($file, 0);
		fputs($file, "<?php \n");
		fputs($file, "	class Config{\n");
		fputs($file, "		public static \$baseDir = '".$_POST['uri']."';\n");
		fputs($file, "		public static \$crypt = '".$_POST['crypt']."';\n");
		fputs($file, "		public static \$logo = '".$_POST['uri'].$uploaddir.basename($_FILES['logo']['name'])."';\n");
		fputs($file, "		public static \$name = '".$_POST['libelle']."';\n");
		fputs($file, "		public static \$theme = '".$theme."';\n");
		fputs($file, "		public static \$tookenValidity = 7200;\n");
		fputs($file, "	}\n");
		fputs($file, "?>");
		
		fclose($file);
		
		
		$file = fopen('../Include/Functions/DAO.php', 'w');
		
		fseek($file, 0);
		fputs($file, "<?php \n");
		fputs($file, "	class DAO{ \n");
		fputs($file, "		private static \$host = '".$_POST['host']."'; \n");
		fputs($file, "		private static \$dbname = '".$_POST['dbname']."'; \n");
		fputs($file, "		private static \$user = '".$_POST['user']."'; \n");
		fputs($file, "		private static \$password  = '".$_POST['password']."'; \n");
		fputs($file, "\n");
		fputs($file, "		private static \$pdo; \n");
		fputs($file, "\n");
		fputs($file, "		public static function connect(){ \n");
		fputs($file, "			if(!isset(self::\$pdo)) \n");
		fputs($file, "				self::\$pdo = new PDO('mysql:host='.self::\$host.';dbname='.self::\$dbname.';charset=utf8', self::\$user, self::\$password); \n");
		fputs($file, "\n");
		fputs($file, "			return self::\$pdo; \n");
		fputs($file, "		} \n");
		fputs($file, "	} \n");
		fputs($file, "?>");
		
		fclose($file);
		
		
		
		$file = fopen('../.htaccess', 'w');
		
		fseek($file, 0);
		fputs($file, "#.htaccess\n");
		fputs($file, "php_value error_log './Logs/error.log'\n");
		fputs($file, "\n");
		fputs($file, "RewriteEngine On\n");
		fputs($file, "RewriteBase ".$_POST['uri']."\n");
		fputs($file, "RewriteCond %{REQUEST_FILENAME} !\.(gif|jpe?g|png|js|css|swf|php|ico|txt|pdf|xml|svg)$\n");
		fputs($file, "RewriteRule ^(.*)$ index.php [L,QSA]\n");
		
		fclose($file);
		
		header( "refresh:1;url=../" );
	}
	else
	{
		echo('Erreur dans le formulaire.');
	}
?>