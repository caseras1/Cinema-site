<?php

$Level = 0; // default level 0
$MenuInUitloggen = '<li><a href="index.php?PaginaNr=98">Inloggen</a></li>'; // default menuknop inloggen

if(LoginCheck($pdo))
{
	//gebruiker is ingelogd, level wordt veranderd in Level uit Sessie
	$Level = $_SESSION['level'];

	//knop inloggen wordt veranderd in knop uitloggen
	$MenuInUitloggen = '<li><a href="index.php?PaginaNr=99">Uitloggen</a></li>';
}

//bouw query
$parameters = array(':Level'=>$Level);
$sth = $pdo->prepare('select * from menu where Level <= :Level');

$sth->execute($parameters);

//menu opbouwen en op scherm tonen
echo '<ul id="menu">';
echo '	<li><a href="index.php">Home</a></li>';//Standaard Homepage

while($row = $sth->fetch())
{
	//menu items uit DB
	echo '	<li><a href="index.php?PaginaNr='.$row['PaginaNr'].'">'.$row['Tekst'].'</a></li>';
}

//knop in of uitloggen obv de hierboven gezette var MenuInUitloggen
echo $MenuInUitloggen;

echo '</ul>';
?>


