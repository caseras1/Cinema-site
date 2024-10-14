<?php
function login($Username, $password, $pdo)
{
	//voer query uit middels prepared statement
	$parameters = array(':Username'=>$Username);
	$sth = $pdo->prepare('SELECT KlantID, Inlognaam, Wachtwoord, Salt, Level FROM klanten WHERE Inlognaam = :Username LIMIT 1');

	$sth->execute($parameters);

	// controleren of de username voorkomt in de DB
	if ($sth->rowCount() == 1) 
	{
		// Variabelen inlezen uit query
		$row = $sth->fetch();
		
		// paswoord hashen met de unieke Salt uit de DB
		$password = hash('sha512', $password . $row['Salt']);

		// controleren of het paswoord overeenkomt met het paswoord uit de DB
		if ($row['Wachtwoord'] == $password) 
		{
			// vraagt de user agent op (later nodig)
			$user_browser = $_SERVER['HTTP_USER_AGENT'];

			$_SESSION['user_id'] = $row['KlantID'];
			$_SESSION['username'] = $Username;
			$_SESSION['level'] = $row['Level'];
			$_SESSION['login_string'] = hash('sha512',
					  $password . $user_browser);
			
			// Login successful.
			return true;
		 } 
		 else 
		 {
			// password incorrect
			return false;
		 }
	}
	else
	{
		// username bestaat niet
		return false;
	}
}

//begin pagina
$Error = NULL;

if(isset($_POST['Inloggen']))
{
	//het knopje inloggen van het formulier is ingedrukt.

	//lees de username en paswoord
	$Username = $_POST['Username'];
	$Password = $_POST['Password'];

	if(login($Username, $Password, $pdo))
	{
		//login succesvol
		echo "U bent succesvol ingelogd";
		RedirectNaarPagina(5);
	}
	else
	{
		//login mislukt
		$Error = "De Inlognaam of het Wachtwoord is onjuist.";
		require('./Forms/InloggenForm.php');
	}
}
else
{	
	//er is nog niet op het knopje gedrukt, het formulier wordt weergegeven
	require('./Forms/InloggenForm.php');
}
?>





