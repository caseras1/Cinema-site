<!--
	Opdracht PM07 STAP 1: Inlogsysteem
	Omschrijving: Maak het formulier met 2 velden en de link naar de pagina registreren in html code
-->

	<h1>Inloggen</h1>
	<?php echo '<br />'.$Error.'<br />';?>
	<form name="InlogFormulier" action="" method="post">
		<label for="Username">Inlognaam:</label>
		<input type="text" id="Username" name="Username" />
		<br />
		<label for="Password">Wachtwoord:</label>
		<input type="password" id="Password" name="Password" />
		<br />		
		<input type="submit" name="Inloggen" value="Log in!" />
	</form>
	<br />
	Heeft u nog geen Account? Registreer dan <a href="index.php?PaginaNr=6">hier</a>
