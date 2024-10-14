<!--
	Opdracht PM08 STAP 1: registreren
	Omschrijving: Geef met commentaar aan wat de stukjes PHP code doen in dit bestand
-->

	
	<h1>Registreren</h1>
	<form name="RegistratieFormulier" action="" method="post">
		<label for="FirstName">Voornaam:</label>
		<input type="text" id="FirstName" name="FirstName" value="<?php echo $FirstName; ?>"/><?php echo $FnameErr; ?>
		<br />
		<label for="LastName">Achternaam:</label>
		<input type="text" id="LastName" name="LastName" value="<?php echo $LastName; ?>" /><?php echo $LnameErr; ?>
		<br />		
		<label for="Adres">Adres:</label>
		<input type="text" id="Adres" name="Adres" value="<?php echo $Adres; ?>" />
		<br />
		<label for="ZipCode">Postcode:</label>
		<input type="text" id="ZipCode" name="ZipCode" value="<?php echo $ZipCode; ?>" /><?php echo $ZipErr; ?>
		<br />		
		<label for="City">Plaats:</label>
		<input type="text" id="City" name="City" value="<?php echo $City; ?>" /><?php echo $CityErr;?>
		<br />
		<label for="TelNr">Telefoon nr.:</label>
		<input type="text" id="TelNr" name="TelNr" value="<?php echo $TelNr; ?>" /><?php echo $TelErr; ?>
		<br />
		<label for="Email">E-mail:</label>
		<input type="text" id="Email" name="Email" value="<?php echo $Email; ?>" /><?php echo $MailErr; ?>
		<br />
		<br />
		<label for="Username">Gewenste Gebruikersnaam:</label>
		<input type="text" id="Username" name="Username" value="<?php echo $Username; ?>" /><?php echo $UserErr; ?>
		<br />		
		<label for="Password">Wachtwoord:</label>
		<input type="password" id="Password" name="Password" /><?php echo $PassErr; ?>
		<br />		
		<label for="RetypePassword">Herhaal Wachtwoord:</label>
		<input type="password" id="RetypePassword" name="RetypePassword" /><?php echo $RePassErr; ?>
		<br />		
		<input type="submit" name="Registreren" value="Registreer!" />
	</form>
	<br />
