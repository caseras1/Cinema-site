<?php
// beveiliging pagina voor niet geautoriseerde bezoekers
if(LoginCheck($pdo))
{
	// user is ingelogd
	if($_SESSION['level'] >= 5) //pagina alleen zichtbaar voor level 5 of hoger
	{
		
	//-------------code---------------//	
		
		//init fields
		$Title = $Description = $Duration = $Genre = $Age = $Picture = $Price = $Type = $Status = NULL;

		//init error fields
		$TitleErr = $DescErr = $DurErr = $PriceErr = NULL;

		if(isset($_POST['Toevoegen']))
		{
			
			$CheckOnErrors = false; // hulpvariabele voor het valideren van het formulier
				
			$Title = $_POST["Title"];
			$Description = $_POST["Description"];
			$Duration = $_POST['Duration'];
			$Genre = $_POST['Genre'];
			$Age = $_POST['Age'];
			$Picture = $_POST['Picture'];
			$Price = $_POST['Price'];
			$Type = $_POST['Type'];
			$Status = $_POST['Status'];
			
			//BEGIN CONTROLES
			//controleert het Titel veld
			if(empty($Title))
			{
				$TitleErr = "dit veld is vereist";
				$CheckOnErrors = true;
			}
			
			//controleert het Omschrijving veld
			if(empty($Description))
			{
				$DescErr = "dit veld is vereist";
				$CheckOnErrors = true;
			}

			//controleert het duration veld
			if(empty($Duration))
			{
				$DurErr = "dit veld is vereist";
				$CheckOnErrors = true;
			}
			elseif(!ctype_digit($Duration))
			{
				$DurErr = "is geen geldig duur formaat";
				$CheckOnErrors = true;
			}
			
			//controleert het Price veld
			if(empty($Price))
			{
				$PriceErr = "dit veld is vereist";
				$CheckOnErrors = true;
			}
			elseif(!is_numeric($Price))
			{
				$PriceErr = "is geen geldige Prijs";
				$CheckOnErrors = true;
			}
			//EINDE CONTROLE

			if($CheckOnErrors)
			{
				//er zijn fouten geconstateerd
				require('./Forms/FilmToevoegenForm.php');
			}
			else
			{
				//formulier is succesvol gevalideerd

				//query opbouwen
				$parameters = array(':Title'=>$Title,
							':Description'=>$Description,
							':Duration'=>$Duration,
							':Genre'=>$Genre,
							':Age'=>$Age,
							':Picture'=>$Picture,
							':Price'=>$Price,
							':Type'=>$Type,
							':Status'=>$Status);

				$sth = $pdo->prepare('INSERT INTO films (FilmID, Titel, Beschrijving, Duur, Genre, Leeftijd, Plaatje, Prijs, Type, Status) VALUES (NULL, :Title, :Description, :Duration, :Genre, :Age, :Picture, :Price, :Type, :Status)');
	
				$sth->execute($parameters);
				
				echo "De Film is toegevoegd aan de Database.";
				RedirectNaarPagina(3,7);
			}
		}
		else
		{
			require('./Forms/FilmToevoegenForm.php');
		}
		

		
	//-------------code--------------//

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
