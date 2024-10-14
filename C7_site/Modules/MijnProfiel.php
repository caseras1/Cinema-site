<?php
// beveiliging pagina voor niet geautoriseerde bezoekers
if(LoginCheck($pdo))
{
	// user is ingelogd
	if($_SESSION['level'] >= 1) //pagina alleen zichtbaar voor level 1 of hoger
	{
		/* ===============CODE================== */
		//init fields
		$FirstName = $LastName = $Adres = $ZipCode = $City = $TelNr = $Email = NULL;

		//init error fields
		$FnameErr = $LnameErr = $ZipErr = $CityErr = $TelErr = $MailErr = NULL;

		if(isset($_POST['Wijzigen']))
		{
			$CheckOnErrors = false; // hulpvariabele voor het valideren van het formulier

			$FirstName = $_POST["FirstName"];
			$LastName = $_POST["LastName"];
			$Adres = $_POST['Adres'];
			$ZipCode = $_POST['ZipCode'];
			$City = $_POST['City'];
			$TelNr = $_POST['TelNr'];
			$Email = $_POST['Email'];

			//BEGIN CONTROLES
			
			//controleert het voornaam veld
			if(empty($FirstName))
			{
				$FnameErr = "dit veld is vereist";
				$CheckOnErrors = true;
			}
			elseif(!is_Char_Only($FirstName) || !is_minlength($FirstName,2))
			{
				$FnameErr = "Mag alleen uit karakters bestaan en is minimaal 2 karakters lang";
				$CheckOnErrors = true;
			}

			//controleert het achternaam veld
			if(empty($LastName))
			{
				$LnameErr = "dit veld is vereist";
				$CheckOnErrors = true;
			}
			elseif(!is_Char_Only($LastName) || !is_minlength($LastName,2))
			{
				$LnameErr = "Mag alleen uit karakters bestaan en is minimaal 2 karakters lang";
				$CheckOnErrors = true;
			}

			//controleert het postcode veld	
			if(!is_NL_PostalCode($ZipCode) && !empty($ZipCode))
			{
				$ZipErr = "is geen geldige postcode";
				$CheckOnErrors = true;
			}

			//controleert het plaats veld
			if(!is_Char_Only($City))
			{
				$CityErr = "Mag alleen uit karakters bestaan";
				$CheckOnErrors = true;
			}

			//controleert het telnr veld
			if(empty($TelNr))
			{
				$TelErr = "dit veld is vereist";
				$CheckOnErrors = true;
			}
			elseif(!is_NL_Telnr($TelNr))
			{
				$TelErr = "is geen geldig telefoonnummer";
				$CheckOnErrors = true;
			}

			//controleert het email veld
			if(empty($Email))
			{
				$MailErr = "dit veld is vereist";
				$CheckOnErrors = true;
			}
			elseif(!is_Email($Email))
			{
				$MailErr = "is geen geldig email adres";
				$CheckOnErrors = true;
			}
			//EINDE CONTROLES

			if($CheckOnErrors)
			{
				//er zijn fouten geconstateerd
				require('./Forms/MijnProfielForm.php');
			}
			else
			{
				//formulier is succesvol gevalideerd

				//query opbouwen
				$parameters = array(':FirstName'=>$FirstName,
							':LastName'=>$LastName,
							':Adres'=>$Adres,
							':ZipCode'=>$ZipCode,
							':City'=>$City,
							':TelNr'=>$TelNr,
							':Email'=>$Email,
							':KlantID'=>$_SESSION['user_id']);

				$sth = $pdo->prepare('UPDATE klanten SET Voornaam = :FirstName, Achternaam = :LastName, Adres = :Adres, Postcode = :ZipCode, Plaats = :City, TelefoonNr = :TelNr, Email = :Email WHERE KlantID = :KlantID');

				$sth->execute($parameters);

				require('./Forms/MijnProfielForm.php');

				echo "Uw gegevens zijn succesvol gewijzigd.";
			}
		}
		else
		{

			//huidige gegevens uitlezen middels gegevens sessie
			$parameters = array(':KlantID'=>$_SESSION['user_id']);
			$sth = $pdo->prepare('SELECT Voornaam,Achternaam,Adres,Postcode,Plaats,TelefoonNr,Email FROM Klanten WHERE KlantID = :KlantID');

			$sth->execute($parameters);
			$row = $sth->fetch();// rij fetchen

			// overzetten naar juiste variabelen voor werking formulier
			$FirstName = $row["Voornaam"];
			$LastName = $row["Achternaam"];
			$Adres = $row['Adres'];
			$ZipCode = $row['Postcode'];
			$City = $row['Plaats'];
			$TelNr = $row['TelefoonNr'];
			$Email = $row['Email'];

			require('./Forms/MijnProfielForm.php');
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
