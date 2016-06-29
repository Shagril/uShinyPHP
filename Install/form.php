<!DOCTYPE html>
<html>
	<head>
		
	</head>
	<body>
		<form enctype="multipart/form-data" action="Install/install.php" method="POST">
			<h1>Configuration :</h1>
			<h2> Parametres :</h2>
			<label for="libelle">Libelle</label>
			<input name="libelle" id="libelle"/>
			<br/>
			<label for="logo">Logo</label>
			<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
			<input type="file" name="logo" id="logo" accept="image/*">
			<br/>
			<label for="theme">Thème</label>
			<select id="theme" name="theme">
				<option value="1" select>Default</option>
				<option value="2">Material Design</option>
			</select>
			<br/>
			<label for="pseudo">Pseudo</label>
			<input name="pseudo" id="pseudo"/>
			<br/>
			<label for="mdp">Mot de Passe</label>
			<input name="mdp" id="mdp"/>
			<br/>
			<h2> Database :</h2>
			
			<label for="host">Host</label>
			<input name="host" id="host"/>
			<br/>
			<label for="dbname">Dbname</label>
			<input name="dbname" id="dbname"/>
			<br/>
			<label for="user">User</label>
			<input name="user" id="user"/>
			<br/>
			<label for="password">Password</label>
			<input name="password" id="password"/>
			<br/>
			<label for="crypt">Cle de cryptage</label>
			<input name="crypt" id="crypt"/>
			<br/>
			<input type="hidden" name="uri" value="<?php echo($_SERVER['REQUEST_URI']); ?>"/>
			
			<input type="submit" name="action" value="Enregistrer"/>
		</form>
	</body>
</html>