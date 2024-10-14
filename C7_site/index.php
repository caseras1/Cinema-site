
<?php
session_start();
require('./Configuratie.php');
require('./Modules/Functies.php');

$pdo = ConnectDB();

if(!empty($_GET['PaginaNr']))
	$PaginaNr = $_GET['PaginaNr'];
else
	$PaginaNr = null;

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="Style.css" />
	<title>Cinema 7</title>
</head>
<body>
<header>
	<img src="./Images/logo.jpg" id="Logo" alt="Cinema 7 Logo" />
</header>
<div id="MenuWrapper">
	<nav>
		<?php
			require('./Modules/Menu.php');
		?>
	</nav>
</div>
<div id="MainWrapper">
	<div id="Banner"></div>
	<main>
		<?php
			
			switch($PaginaNr)
			{
				case 1:	require('./Modules/Reserveren.php');
						break;
				case 2:	require('./Modules/Verwacht.php');
						break;
				case 3:	require('./Modules/OverOns.php');
						break;
				case 4:	require('./Modules/MijnProfiel.php');
						break;
				case 6:	require('./Modules/Registreren.php');
						break;
				case 7:	require('./Modules/FilmToevoegen.php');
						break;
				case 8:	require('./Modules/FilmAanpassenVerwijderen.php');
						break;
				case 9:	require('./Modules/Data.Tijden.php');
						break;
				case 10:require('./Modules/Besteloverzicht.php');
						break;
				case 11:require('./Modules/BestellingVerwerken.php');
						break;
				case 98:require('./Modules/Inloggen.php');
						break;
				case 99:require('./Modules/Uitloggen.php');
						break;
				default:require('./Modules/Home.php');
						break;
			}


		?>
	</main>
</div>
</body>
</html>