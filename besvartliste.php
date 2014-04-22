<?php 
//Denne siden er utviklet av Kurt A. Amodt., siste gang endret 30.03.2014
//Denne siden er kontrollert av Erik Bjørnflaten siste gang 30.03.2014

include_once 'includes/init.php';
$db = getDB(); 



//Registrerer ny respons til databasen
if(!empty($_POST['lagrerespons'])) {
		$innleveringerPK 	= trim($_POST['oppgPK']);
		$respons 	= sanitize(trim($_POST['respons']));
		$veileder   = $user_data['brukerPK'];
				
		if(!empty($innleveringerPK) && !empty($respons))  {
				$insert = $db->prepare("INSERT INTO respons (innlevering, veileder, respons, responsDato) VALUES (?,?,?,now())");
				$insert->bind_param('iis', $innleveringerPK, $veileder, $respons);
		
				if($insert->execute()) {
					header('Location: oppgave.php?lagretrespons');
					die();
				} else { header('Location: oppgave.php?nosaveerror'); }
		} else { header('Location: oppgave.php?tomerror'); } 
}
 
    ?>
<div class=bliste><table>
	     <thead>
		    <tr>
		    	<th class='tab2'>Bruker</th>
		    	<th class='tab2'>Oppgavetittel</th>
		        <th class='tab2'>Innleveringsdato</th>
		        <th class='tab2'>Tid brukt</th>
		        <th class='tab2'>Antall feil</th>
		        <th><input type="text" id="search" placeholder="  Søk"></input></th>
		    </tr>
	    </thead>
    <tbody>
    <?php

    $result = oppgListe("besvart"); //Henter liste med besvarelser uten responser
    while ($row = $result->fetch_assoc()) {
    $PK = $row['innleveringPK'];
    $besvarelse = $row['tekstInnlevering'];
  	$sanitized = nl2br(htmlspecialchars($besvarelse, ENT_QUOTES));
  	$bruker = finnBruker($row['bruker']); //Henter etternavn til brukeren
  	$oppgavetittel = hentOppgt($row['oppgave']);
  	
    echo "<form action='besvartliste.php' method='POST'>";
    echo "<tr>";
    echo "<td id='bruker".$PK."'      	 	 name='bruker'    		>"	. $bruker.	 			 "</td>";
    echo "<td id='oppgtittel".$PK."'    	 name='oppgtittel'    	>"	. $oppgavetittel .	 	 "</td>";
    echo "<td id='datoLevert".$PK."'    	 name='datoLevert'  	>"	. $row['datoLevert'] .	 "</td>";
    echo "<td id='tidBrukt".$PK."'    	 	 name='tidBrukt'    	>"	. $row['tidBrukt'] .	 "</td>";
 	echo "<td id='antallFeil".$PK."'    	 name='antallFeil'    	>"	. $row['antallFeil'] .	 "</td>";
    echo "<input type='hidden' name='oppgPK' value=$PK />";


    //Viser besvarelsen i en dialogboks med inputfelt for responen
   	echo "<td><a href='#openModal".$PK."'><img src='img/respons.png' alt='Vis besvarelsen' title='Vis besvarelsen'></a>"; 
   	echo "<div id='openModal".$PK."' class='modalDialog'>
			<div>
				<a href='#close' title='Close' class='close'>X</a>
				<h2>$oppgavetittel</h2>
				$sanitized
				<br>
				<br>
				<textarea id='responstext' placeholder='Skriv respons' name='respons'></textarea>
				<br>";
	echo	"<input id='responsid".$PK."' type='submit' name='lagrerespons'>
			</div>
		</div>";
    echo "</td></tr></form>";
	} echo  "<tbody></table></div>";
?>
