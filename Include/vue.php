<?php

	echo('
		<!DOCTYPE html>
		<html>
			<head>
				<script src="'.Config::$baseDir.'Include/Resources/js/jquery-1.10.2.min.js"></script>

				
				<script>
					$(document).ready(function(){
						$(\'[data-toggle="tooltip"]\').tooltip({container: "body"});
						$(\'[data-toggle="popover"]\').popover({container: "body"});
					});
				</script>
				
				<meta charset="UTF-8"/>
				<meta name="viewport" content="width=device-width, initial-scale=1">
				
				<!-- Latest compiled and minified CSS -->
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous" media="screen">
				<!-- Optional theme -->
				<link rel="stylesheet" href="'.Config::$theme.'" media="screen">
				<!-- Latest compiled and minified JavaScript -->
				<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
				
				
				<link rel="stylesheet" href="'.Config::$baseDir.'Include/Resources/css/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css" media="screen">
				<script type="text/javascript" src="'.Config::$baseDir.'Include/Resources/js/bootstrap-datetimepicker/bootstrap-datetimepicker.js" charset="UTF-8"></script>
				<script type="text/javascript" src="'.Config::$baseDir.'Include/Resources/js/bootstrap-datetimepicker/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
				<link rel="stylesheet" href="'.Config::$baseDir.'Include/Resources/css/screen-design.css" media="screen"> <!-- Version PC -->
				<link rel="stylesheet" href="'.Config::$baseDir.'Include/Resources/css/mobile-design.css" media="screen"> <!-- Version Mobile -->
				
			</head>
			<body>
				<!-- Header -->
				<div class="page-header">
					<!-- Nav -->
					<div class="navbar navbar-inverse">
						<div class="container-fluid">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
								<a class="navbar-brand logo" href="'.Config::$baseDir.'"><img src="'.Config::$logo.'" alt="'.Config::$name.'"</img></a>
							</div>
							<div class="collapse navbar-collapse" id="bs-navbar-collapse">
								<ul class="nav navbar-nav">
									'.$nav.'
								</ul>
								<ul class="nav navbar-nav navbar-right">
									'.$rightNav.'
								</ul>
							</div>
						</div>
					</div>
					<!-- Fin Nav -->
				</div>
				<!-- Fin Header -->
				
				
				
				<!-- Jumbotron -->
				<div class="jumbotron">
					'.$content.'
				</div>
				<!-- Fin Jumbotron -->
				
				<!-- Footer -->
				<footer>
					<span class="pull-right" style="color:#bfb9bf;">'.Config::$name.' - 2016 - <a style="text-decoration:none; color:#bfb9bf;" href="mailto://shagril@hotmail.fr">Shagril De Fargot</a></span>
				</footer>
				<!-- Fin Footer -->
			</body>
		</html>
	');
?>