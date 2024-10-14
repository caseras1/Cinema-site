<?php

$parameters = array(':Status'=>'Verwacht');
$sth = $pdo->prepare('select * from films where Status = :Status');

$sth->execute($parameters);

//tabel is voorbeeld. leerling moet zelf een layout maken
echo '<table border="0">';
echo '<tr>';
echo	'<th></th>';
echo	'<td>Titel</td>';
echo	'<td>Duur</td>';
echo	'<td>Genre</td>';
echo	'<td>Leeftijd</td>';
echo '</tr>';

while($row = $sth->fetch())
{
	echo '<tr>';
	echo '<td rowspan="2"><img src="./Images/'.$row['Plaatje'].'" alt="'.$row['Titel'].'"</td>';
	echo '<td>'.$row['Titel'].'</td>';
	echo '<td>'.$row['Duur'].'</td>';
	echo '<td>'.$row['Genre'].'</td>';
	echo '<td>'.$row['Leeftijd'].'</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td colspan="4">'.$row['Beschrijving'].'</td>';
	echo '</tr>';
}
echo '</table>';

?>

