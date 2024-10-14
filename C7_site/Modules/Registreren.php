<?php
//init fields
$FirstName = $LastName = $Adres = $ZipCode = $City = $TelNr = $Email = $Username = 	$Password = $RetypePassword = NULL;

//init error fields
$FnameErr = $LnameErr = $ZipErr = $CityErr = $TelErr = $MailErr = $UserErr = $PassErr = $RePassErr = NULL;

if(isset($_POST['Registreren']))
{
	$CheckOnErrors = false; // hulpvariabele voor het valideren van het formulier

	$FirstName = $_POST["FirstName"];
	$LastName = $_POST["LastName"];
	$Adres = $_POST['Adres'];
	$ZipCode = $_POST['ZipCode'];
	$City = $_POST['City'];
	$TelNr = $_POST['TelNr'];
	$Email = $_POST['Email'];
	$Username = $_POST['Username'];
	$Password = $_POST['Password'];
	$RetypePassword = $_POST['RetypePassword'];

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
	//controleert het username veld
	if(empty($Username))
	{
		$UserErr = "dit veld is vereist";
		$CheckOnErrors = true;
	}
	elseif(!is_Username_Unique($Username,$pdo))
	{
		$UserErr = "deze Username bestaat al, kies een andere";
		$CheckOnErrors = true;
	}

	//controleert het paswoord veld
	if(empty($Password))
	{
		$PassErr = "dit veld is vereist";
		$CheckOnErrors = true;
	}
	elseif(!is_minlength($Password,6))
	{
		$PassErr = "het wachtwoord moet uit minimaal 6 tekens bestaan";
		$CheckOnErrors = true;
	}
	
	//controleert het retype paswoord veld
	if(empty($RetypePassword))
	{
		$RePassErr = "dit veld is vereist";
		$CheckOnErrors = true;
	}
	elseif($Password != $RetypePassword)
	{
		$RePassErr = "De 2 wachtwoord velden komen niet overeen";
		$CheckOnErrors = true;
	}
	//EINDE CONTROLE

	if($CheckOnErrors)
	{
		//er zijn fouten geconstateerd
		require('./Forms/RegistrerenForm.php');
	}
	else
	{
		//formulier is succesvol gevalideerd

		//maak unieke salt
		$Salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));

		//hash het paswoord met de Salt
		$Password = hash('sha512', $Password . $Salt);

		//query opbouwen
		$parameters = array(':FirstName'=>$FirstName,
					':LastName'=>$LastName,
					':Adres'=>$Adres,
					':ZipCode'=>$ZipCode,
					':City'=>$City,
					':TelNr'=>$TelNr,
					':Email'=>$Email,
					':Username'=>$Username,
					':Password'=>$Password,
					':Salt'=>$Salt,
					':Level'=>1);

		$sth = $pdo->prepare('INSERT INTO klanten (Voornaam, Achternaam, Adres, Postcode, Plaats, TelefoonNr, Email, Inlognaam, Wachtwoord, Salt, Level) VALUES (:FirstName, :LastName, :Adres, :ZipCode, :City, :TelNr, :Email, :Username, :Password, :Salt, :Level)');

		$sth->execute($parameters);

		echo "U heeft zich succesvol geregistreerd.";
		RedirectNaarPagina(2,98);
	}
}
else
{
	require('./Forms/RegistrerenForm.php');
}
?>