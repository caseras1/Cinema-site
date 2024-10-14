<!-- 
	Opdracht PM12 STAP 1 : Film Aanpassen
	Maak hier het formulier waarmee je een film kan aanpassen in de database. Let op: dit formulier is vrijwel identiek aan het formulier uit de vorige opdracht
-->

	
	<h1>Film Aanpassen</h1>
	<form name="FilmToevoegenFormulier" action="" method="post">
		<label for="Title">Titel:</label>
		<input type="text" id="Title" name="Title" value="<?php echo $Title; ?>"/><?php echo $TitleErr; ?>
		<br />
		<label for="Description">Beschrijving:</label><br />
		<textarea rows="4" cols="50" id="Description" name="Description"><?php echo $Description; ?></textarea>
		<?php echo $DescErr; ?>
		<br />		
		<label for="Duration">Duur:</label>
		<input type="text" id="Duration" name="Duration" maxlength="3" value="<?php echo $Duration; ?>" /><?php echo $DurErr; ?>
		<br />
		<label for="Genre">Genre:</label>
		<select id="Genre" name="Genre">
			<option value="Actie" <?php if($Genre=="Actie"){echo "selected";} ?>>Actie</option>
			<option value="Avontuur" <?php if($Genre=="Avontuur"){echo "selected";} ?>>Avontuur</option>
			<option value="Thriller" <?php if($Genre=="Thriller"){echo "selected";} ?>>Thriller</option>
			<option value="Horror" <?php if($Genre=="Horror"){echo "selected";} ?>>Horror</option>
			<option value="Drama" <?php if($Genre=="Drama"){echo "selected";} ?>>Drama</option>
			<option value="Western" <?php if($Genre=="Western"){echo "selected";} ?>>Western</option>
			<option value="Oorlog" <?php if($Genre=="Oorlog"){echo "selected";} ?>>Oorlog</option>
			<option value="Komedie" <?php if($Genre=="Komedie"){echo "selected";} ?>>Komedie</option>
		</select> 
		<br />		
		<label for="Age">Min. Leeftijd:</label>
		<select id="Age" name="Age">
			<option value="ALL" <?php if($Age=="ALL"){echo "selected";} ?>>ALL</option>
			<option value="6" <?php if($Age=="6"){echo "selected";} ?>>6</option>
			<option value="12" <?php if($Age=="12"){echo "selected";} ?>>12</option>
			<option value="16" <?php if($Age=="16"){echo "selected";} ?>>16</option>
			<option value="18" <?php if($Age=="18"){echo "selected";} ?>>18</option>
		</select> 
		<br />
		<label for="Picture">Plaatje Poster:</label>
		<input type="text" id="Picture" name="Picture" value="<?php echo $Picture; ?>" />
		<br />
		<label for="Price">Prijs:</label>
		<input type="text" id="Price" name="Price" value="<?php echo $Price; ?>" />
		<?php echo $PriceErr; ?>
		<br />
		<br />
		<label for="Type">Type:</label>
		<select id="Type" name="Type">
			<option value="Normaal" <?php if($Type=="Normaal"){echo "selected";} ?>>Normaal</option>
			<option value="3D" <?php if($Type=="3D"){echo "selected";} ?>>3D</option>
			<option value="IMAX" <?php if($Type=="IMAX"){echo "selected";} ?>>IMAX</option>
			<option value="IMAX 3D" <?php if($Type=="IMAX 3D"){echo "selected";} ?>>IMAX 3D</option>
		</select> 
		<br />		
		<label for="Status">Status:</label>
		<select id="Status" name="Status">
			<option value="Verwacht" <?php if($Status=="Verwacht"){echo "selected";} ?>>Verwacht</option>
			<option value="InBios" <?php if($Status=="InBios"){echo "selected";} ?>>InBios</option>
		</select> 
		<br />		
		<input type="submit" name="Aanpassen" value="Aanpassen!" />
	</form>
	<br />
