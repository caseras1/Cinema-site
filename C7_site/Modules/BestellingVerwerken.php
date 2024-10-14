<?php
// beveiliging pagina voor niet geautoriseerde bezoekers
if(LoginCheck($pdo))
{
	// user is ingelogd
	if($_SESSION['level'] >= 1) //pagina alleen zichtbaar voor level 1 of hoger
	{
		/* ===============CODE================== */

		
		if(!empty($_SESSION['BestelBeveiliging']))
		{

			$Bestelling = $_SESSION['bestelling'];

			//query opbouwen
			$parameters = array(':KlantID'=>$_SESSION['user_id']);

			$sth = $pdo->prepare('INSERT INTO reserveringen (KlantID) VALUES (:KlantID)');

			$sth->execute($parameters);
			
			$ReserveringsID = $pdo->lastInsertId();

			$sth = $pdo->prepare('INSERT INTO reserveringen_vertoningen (ReserveringsID,VertoningsID,AantalKaartjes) VALUES (:ReserveringsID,:VertoningsID,:AantalKaartjes)');
			
			for($i=0;$i<count($Bestelling);$i++)
			{
				$parameters = array(':ReserveringsID'=>$ReserveringsID,
									':VertoningsID'=>$Bestelling[$i]['VertoningsId'],':AantalKaartjes'=>$Bestelling[$i]['AantalKaartjes']);
				$sth->execute($parameters);
			}

			echo 'Uw bestelling is succesvol bij ons ontvangen!<br />';
			echo 'De bestelling is bij ons bekend onder bestelnr.: '.$ReserveringsID.'<br />';
			echo 'Wij bedanken u voor uw vertrouwen in ons en wensen u al vast veel plezier met de voorstelling.<br /><br />';
			echo '<a href="index.php">Terug naar de Homepage</a>';
			
			//verwijderd de session variabele met bestelgegevens -- DO NOT REMOVE!
			unset($_SESSION['bestelling']);
			unset($_SESSION['BestelBeveiliging']);
		}
		else
			echo '<img src="./Images/EasterEgg.jpg" alt="Dennis Nedry" />';
		
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
