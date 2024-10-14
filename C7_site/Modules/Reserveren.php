<?php
try {
	$pdo = new PDO("mysql:host=localhost;dbname=cinema7", "root", "");
	
	$query = $pdo->prepare("SELECT * FROM films WHERE STATUS = 'Verwacht' ");
		$query->execute();
	   
		$result = $query->fetchAll (PDO::FETCH_ASSOC);
	
	foreach($result as &$data) {
		echo "<br><br>";	
		echo "<table id=list>";
		echo "<tr>
		<th>Titel</th>
		<th>Beschrijving</th>
		<th>Plaatje</th>
		<th>Prijs</th>
		<th>Reserveer</th>
		
		</tr>";
		
		echo "<tr>";
		echo "<td><div class =Title> $data[Titel] </a></div></td>";
		echo "<td><div class =Beschrijving> $data[Beschrijving] </a></div></td>";
		echo "<td><div class=Plaatje> <img src=./Images/$data[Plaatje]" . "  width= 140 height= 145></a></td></div>";
		echo "<td><div class =Prijs> &euro; ". number_format($data['Prijs'],0,",",".") . " </a></div></td>";
		echo "<td><div class = reserveer>" . '<a href="?">Reserveer</a>'. "</td></div>";
		echo "</tr>";
		
		
		}
	} catch(PDOException $e) {
	die("Error!: " . $e->getMessage());
	}
		



?>

