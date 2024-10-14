<?php
// beveiliging pagina voor niet geautoriseerde bezoekers
if(LoginCheck($pdo))
{
	// user is ingelogd
	if($_SESSION['level'] >= 1) //pagina alleen zichtbaar voor level 1 of hoger
	{
		/* ===============CODE================== */
		

		if(isset($_POST['BestelOverzicht']))
		{

			$FilmId = $_GET['FilmId'];
			$VertoningsId = $_POST['VertoningsId'];
			$AantalKaartjes = $_POST['AantalKaartjes'];
			$Titel = $_POST['FilmTitel'];
			$Prijs = $_POST['Prijs'];
			$Film = array('VertoningsId' => $VertoningsId,
						  'FilmId' => $FilmId,
						  'Titel' => $Titel,
						  'Prijs' => $Prijs,
						  'AantalKaartjes' => $AantalKaartjes);


			if(isset($_SESSION['bestelling']))
			{
				$Bestelling = $_SESSION['bestelling'];
				$Bestelling[] = $Film;
				$_SESSION['bestelling']= $Bestelling;
			}
			else
			{
				$Bestelling = array();
				$Bestelling[] = $Film;
				$_SESSION['bestelling']= $Bestelling;
			}

			header("location:index.php?PaginaNr=10");
		}
		else
		{
			$FilmId = $_GET['FilmId'];

			$parameters = array(':FilmId'=>$FilmId);
			$sth = $pdo->prepare('SELECT f.Titel, f.Prijs, v.* FROM Films f, Vertoningen v WHERE v.FilmId = f.FilmId AND v.FilmId = :FilmId');

			$sth->execute($parameters);
			
			$row = $sth->fetch();
			
			echo '<h1>Film Reserveren: '.$row['Titel'].'</h1>';
			echo '<h3>prijs: &#8364;'.number_format($row['Prijs'],2).'pp</h3><br />';

			echo '<form name="VertoningenForm" method="post" action="">';
			echo '<input type="hidden" name="FilmTitel" value="'.$row['Titel'].'" />';
			echo '<input type="hidden" name="Prijs" value="'.$row['Prijs'].'" />';
			echo '<table border="1">';
			echo '<tr>';
			echo	'<th>Datum:</th>';
			echo	'<th>Tijd:</th>';
			echo	'<th>ZaalNr:</th>';
			echo	'<th>Selecteren:</th>';
			echo '</tr>';
			echo '<tr>';
			echo	'<td>'.date('d-m-Y',strtotime($row['Datum'])).'</td>';
			echo	'<td>'.substr($row['Tijd'],0,5).'</td>';
			echo	'<td>'.$row['ZaalNR'].'</td>';
			echo	'<td><input type="radio" name="VertoningsId" value="'.$row['VertoningsID'].'" /></td>';
			echo '</tr>';

			while($row = $sth->fetch())
			{
			echo '<tr>';
			echo '<td>'.date('d-m-Y',strtotime($row['Datum'])).'</td>';
			echo '<td>'.substr($row['Tijd'],0,5).'</td>';
			echo '<td>'.$row['ZaalNR'].'</td>';
			echo '<td><input type="radio" name="VertoningsId" value="'.$row['VertoningsID'].'" /></td>';
			echo '</tr>';
			}

			echo '<tr>';
			echo '<td colspan="3">Kies aantal Kaartjes:</td>';
			echo '<td>
					<select id="AantalKaartjes" name="AantalKaartjes">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
					</select> 
				  </td>';				
			echo '</tr>';
			echo '<tr>';
			echo '<td colspan="3">&nbsp;</td>';
			echo '<td><input type="submit" name="BestelOverzicht" value="Verder" /></td>';
			echo '</tr>';
			echo '</table>';
			echo '</form>';
		}

		/* ===============CODE================== */
	}
	else
	{
		//user heeft niet het correcte level
		echo 'U heeft niet de juiste bevoegdheid voor deze pagina.';
		RedirectNaarPagina(5);//redirect naar home
	}
}
else
{
	//user is niet ingelogd
	RedirectNaarPagina(NULL,98);//instant redirect naar inlogpagina
}
?>
