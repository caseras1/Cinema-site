<?php
/* Bestand met handige PHP functies */

/*
	Opdracht PM04 STAP 1: Verwacht in de bioscoop
	Omschrijving: Vul de Functie ConnectDb aan zodat er werkelijk een connectie wordt gemaakt. Maak gebruik van de constanten uit het Configuratie.php bestand.
*/
function ConnectDB()
{
	try
	{
		$pdo = new PDO("mysql:host=".HOST.";dbname=".DBNAME,USERNAME,PASSWORD);
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}

	return $pdo;
}

/** De functie RedirectNaarPagina
  * optionele parameter PaginaNr. Hiermee kun je de gebruiker naar
  * iedere gewenste pagina doorsturen
  */
function RedirectNaarPagina($Seconds = NULL,$PaginaNr = NULL)
{
	if(!empty($Seconds))
		$Refresh = 'Refresh: '.$Seconds.';URL=';
	else
		$Refresh = 'location:';

	if(!isset($PaginaNr))
	{
		echo "<br />U wordt binnen ".$Seconds." seconden doorgestuurd naar de hoofdpagina.";
		header($Refresh . "index.php");
	}
	else
		header($Refresh . "index.php?PaginaNr=".$PaginaNr);
}

/** De functie LoginCheck
  * controleert of de gebruiker is ingelogd
  */
function LoginCheck($pdo) 
{
    // Controleren of Sessie variabelen bestaan
    if (isset($_SESSION['user_id'], $_SESSION['username'],$_SESSION['login_string'])) 
	{
        $KlantID = $_SESSION['user_id'];
        $Login_String = $_SESSION['login_string'];
        $Username = $_SESSION['username'];
 
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
		echo "user agent $user_browser";
 
		$parameters = array(':KlantID'=>$KlantID);
		$sth = $pdo->prepare('SELECT Wachtwoord FROM klanten WHERE KlantID = :KlantID LIMIT 1');
 
       	$sth->execute($parameters);

		// controleren of de klant voorkomt in de DB
		if ($sth->rowCount() == 1) 
		{
			// Variabelen inlezen uit query
			$row = $sth->fetch();

			//check maken
		    $Login_Check = hash('sha512', $row['Wachtwoord'] . $user_browser);
 
				//controleren of check overeenkomt met sessie
                if ($Login_Check == $Login_String)
					return true;
                else 
                   return false;
         } else 
              return false;         
     } else 
          return false;
}

/* Functies voor validatie van Form Fields */

/** Controleert een email adres op geldigheid
  * @return  boolean
  */
  function is_email($Invoer)
  {
	 return (bool)(preg_match("^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$^",$Invoer));
   }


  /** Controleert of een string aan de minimum lengte voldoet
  * @return  boolean
  */
  function is_minlength($Invoer, $MinLengte)
  {
	return (strlen($Invoer) >= (int)$MinLengte);
  }

  /** Controleert of invoer een NL postcode is
  * @return  boolean
  */
  function is_NL_PostalCode($Invoer)
  {
	return (bool)(preg_match('#^[1-9][0-9]{3}\h*[A-Z]{2}$#i', $Invoer));
  }

  /** Controleert of invoer een NL telefoonnr is
  * @return  boolean
  */
  function is_NL_Telnr($Invoer)
  {
	return (bool)(preg_match('#^0[1-9][0-9]{0,2}-?[1-9][0-9]{5,7}$#', $Invoer) 
               && (strlen(str_replace(array('-', ' '), '', $Invoer)) == 10));
  }


/** Controleert of invoer alleen uit letters bestaat
  * @return  boolean
  */
  function is_Char_Only($Invoer)
  {
	return (bool)(preg_match("/^[a-zA-Z ]*$/", $Invoer)) ;
  }

//iiii
  function is_Username_Unique($Invoer,$pdo)
  {
	$parameters = array(':Username'=>$Invoer);
	$sth = $pdo->prepare('SELECT KlantID FROM klanten WHERE Inlognaam = :Username LIMIT 1');

	$sth->execute($parameters);

	// controleren of de username voorkomt in de DB
	if ($sth->rowCount() == 1) 
		return false;//username komt voor
	else
		return true;//username komt niet voor
  }

?>
