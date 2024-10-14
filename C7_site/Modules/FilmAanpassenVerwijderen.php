<?php
// beveiliging pagina voor niet geautoriseerde bezoekers
if(LoginCheck($pdo))
{
	// user is ingelogd
	if($_SESSION['level'] >= 5) //pagina alleen zichtbaar voor level 5 of hoger
	{
		//-------------code---------------//	
		
		if(isset($_GET['Action']))
		{
			//haalt de action op die bepaald of de film gewijzigd of verwijderd wordt
			$Action = $_GET['Action'];
			
			//switch die bepaald wat er gebeurt wanneer de action Edit of Del is.
			switch($Action)
			{
				case 'Edit':

							//init fields
							$Title = $Description = $Duration = $Genre = $Age = $Picture = $Price = $Type = $Status = NULL;

							//init error fields
							$TitleErr = $DescErr = $DurErr = $PriceErr = NULL;
							
							//controleert of het formulier is ge-submit. LET OP: de knop moet Aanpassen heten
							if(isset($_POST['Aanpassen']))
							{	
								//formulier is gesubmit 

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
									require('./Forms/FilmAanpassenForm.php');
								}
								else
								{
									//formulier is succesvol gevalideerd

									//query opbouwen
									$parameters = array(':FilmID'=>$_GET['FilmId'],
												':Title'=>$Title,
												':Description'=>$Description,
												':Duration'=>$Duration,
												':Genre'=>$Genre,
												':Age'=>$Age,
												':Picture'=>$Picture,
												':Price'=>$Price,
												':Type'=>$Type,
												':Status'=>$Status);

									$sth = $pdo->prepare('UPDATE films SET Titel = :Title, Beschrijving = :Description, Duur = :Duration, Genre = :Genre, Leeftijd = :Age, Plaatje = :Picture, Prijs = :Price, Type = :Type, Status = :Status WHERE FilmID = :FilmID');
						
									$sth->execute($parameters);
									
									echo "De Film gegevens zijn succesvol aangepast";
									RedirectNaarPagina(3,8);
								}
							}
							else
							{
								//formulier is nog niet gesubmit
								$parameters = array(':FilmID'=>$_GET['FilmId']);

								$sth = $pdo->prepare('SELECT * FROM Films WHERE FilmID = :FilmID');

								$sth->execute($parameters);
								$row = $sth->fetch();// rij fetchen

								// overzetten naar juiste variabelen voor werking formulier
								$Title = $row["Titel"];
								$Description = $row["Beschrijving"];
								$Duration = $row['Duur'];
								$Genre = $row['Genre'];
								$Age = $row['Leeftijd'];
								$Picture = $row['Plaatje'];
								$Price = $row['Prijs'];
								$Type = $row['Type'];
								$Status = $row['Status'];
						
								require('./Forms/FilmAanpassenForm.php');
							}
							break;
				case 'Del': 							
							//let op dat je altijd het filmID meegeeft aan de DELETE!!!!!!
							$parameters = array(':FilmID'=>$_GET['FilmId']);

							$sth = $pdo->prepare('DELETE FROM Films WHERE FilmID = :FilmID');

							$sth->execute($parameters);

							
							echo "De Film is verwijderd";
							RedirectNaarPagina(3,8);
							break;
			}
		}
		else
		{
			//uitlezen films
			$sth = $pdo->prepare('select * from films');
			$sth->execute();

			echo '<table border="0">';
			echo '<tr>';
			echo	'<th></th>';
			echo	'<td>Titel</td>';
			echo	'<td>Duur</td>';
			echo	'<td>Genre</td>';
			echo	'<td>Leeftijd</td>';

			//type en prijs toegevoegd
			echo	'<td>Type</td>';
			echo	'<td>Prijs</td>';
			echo '</tr>';

			while($row = $sth->fetch())
			{
				echo '<tr>';
				echo '<td rowspan="2"><img src="./Images/'.$row['Plaatje'].'" alt="'.$row['Titel'].'"</td>';
				echo '<td>'.$row['Titel'].'</td>';
				echo '<td>'.$row['Duur'].'</td>';
				echo '<td>'.$row['Genre'].'</td>';
				echo '<td>'.$row['Leeftijd'].'</td>';

				//type toegevoegd
				echo '<td>'.$row['Type'].'</td>';
				//prijs toegevoegd. Middels number_format op 2 decimalen afgerond
				echo '<td>&#8364; '.number_format($row['Prijs'], 2, ',', '').'</td>';
				
				echo '</tr>';
				echo '<tr>';
				echo '<td colspan="4">'.$row['Beschrijving'].'</td>';

				// LET OP: pagina nr goed instellen , Film ID meegeven , en Action aangeven als GET parameters
				echo '<td><a href="./index.php?PaginaNr=8&Action=Edit&FilmId='.$row['FilmID'].'">Aanpassen</a></td>';

				echo '<td><a href="./index.php?PaginaNr=8&Action=Del&FilmId='.$row['FilmID'].'">Verwijderen</a></td>';

				echo '</tr>';
			}
			echo '</table>';

		}

	//-------------code--------------//


	}
	else
	{
		//user heeft niet het correcte level
		echo 'U heeft niet de juiste bevoegdheid voor deze pagina.';
		RedirectNaarPagina();//redirect naar home
	}
}
else
{
	//user is niet ingelogd
	RedirectNaarPagina(NULL,98);//instant redirect naar inlogpagina
}
?>