<!-- 
	Opdracht 4.03 : Mijn Profiel 
	Maak hier het formulier voor de pagina Mijn Profiel. Let op: dit lijkt sterk op het formulier Registreren
-->
	
	<h1>MijnProfiel</h1>
	<form name="MijnProfielFormulier" action="" method="post">
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
		<input type="submit" name="Wijzigen" value="Wijzigen!" />
	</form>
	<br />
