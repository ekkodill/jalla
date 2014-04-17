<!--Denne siden er utviklet av Kurt A. Amodt., siste gang endret 30.03.2014
Denne siden er kontrollert av Erik Bjørnflaten siste gang 30.03.2014  !-->
<div class=besvart><table>
	     <thead>
		    <tr>
		        <th class='tabbes'>Tittel</th>
		        <th class='tabbes'>Dato levert</th>
		        <th class='tabbes'>Tid brukt</th>
            <th class='tabbes'>Antall feil</th>
            <th class='tabbes'>Vedlegg</th>
            <th class='tabbes'>Ferdig</th>
            <th class='tabbes'>Valg</th>
	    	</tr>
	    </thead>
    <tbody>
    <?php
    $brukerPK = $user_data['brukerPK'];
    /*$result = $db->query("
        SELECT innleveringer.*, oppgaver.* FROM innleveringer
        JOIN oppgaver ON innleveringer.oppgave = oppgaver.oppgavePK AND innleveringer.bruker = $brukerPK");
*/
$result = $db->query("
SELECT innleveringer.*, oppgaver.*, respons.* FROM innleveringer
        JOIN oppgaver ON innleveringer.oppgave = oppgaver.oppgavePK
        LEFT JOIN respons ON innleveringer.innleveringPK = respons.innlevering WHERE innleveringer.bruker = $brukerPK
GROUP BY innleveringer.innleveringPK");

while ($row = $result->fetch_assoc()) {
    

    $PK = $row['innleveringPK'];
    $oppgavePK = $row['oppgave'];
  	$innlevertTekst = $row['tekstInnlevering'];
    $datoLevert = $row['datoLevert'];
    $tidBrukt = $row['tidBrukt'];
    $antFeil = $row['antallFeil'];
    $ferdig = $row['ferdig'];
    $datorespons = $row['responsDato'];
    $respons = $row['respons'];
    if($ferdig == 1) { $ferdig = 'Ja'; } else { $ferdig = 'Nei'; }
    $sanitized = nl2br(htmlspecialchars($innlevertTekst, ENT_QUOTES));

    $vanskelighetsgrad = "ikke valgt";

  	if ($row['vanskelighetsgrad'] === "3") {$vanskelighetsgrad = "Vanskelig"; }
    if ($row['vanskelighetsgrad'] === "2") {$vanskelighetsgrad = "Medium"; }
    if ($row['vanskelighetsgrad'] === "1") {$vanskelighetsgrad = "Lett";}
 
    echo "<form action='skriv.php' method='POST'>";
    echo "<tr>";
    echo "<td id='tittel".$PK."'        	 name='tittel'     >"  . $row['tittelOppgave'].					"</td>";
    echo "<td id='datoLevert".$PK."'    	 name='datoLevert' >"  . $row['datoLevert'].					"</td>";
    echo "<td id='tidBrukt".$PK."'           name='tidBrukt'   >"  . $row['tidBrukt'].                      "</td>";
    echo "<td id='antFeil".$PK."'            name='antFeil'    >"  . $row['antallFeil'].                    "</td>";
    echo "<td id='link".$PK."'    			 name='link'       ><a href='vedlegg/".$row['linkVedlegg']."'>".$row['linkVedlegg']."</a></td>";
    echo "<td id='ferdig".$PK."'             name='ferdig'      >"  . $ferdig.                    "</td>";
   	echo "<input type='hidden' name='oppgPK' value=$oppgavePK />";
    echo "<input type='hidden' name='tittel' value=".$row['tittelOppgave']."/>";
    echo "<input type='hidden' name='oppgtxt' value=".$row['tekstOppgave']."/>";
    


   	echo "<td><a href='#openModal".$PK."'><img src='img/open.png' alt='Vis innleveringen' title='Vis innleveringen'></a>"; //Viser oppgaven
   	echo "<div id='openModal".$PK."' class='modalDialog'>
			<div>
				<a href='#close' title='Close' class='close'>X</a>
                <h4>Vanskelighetsgrad: ".$vanskelighetsgrad."
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Utført den: ".$datoLevert."</h4>
                <h4>Antall feil: ".$antFeil."
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tid brukt: ".$tidBrukt."</h4>
                <h4>Respons: ".$respons."
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp Respons dato: ".$datorespons."</h4>
                <hr size='1' noshade>
				<h2>".$row['tittelOppgave']."</h2>
        		$sanitized
        <br><br><br>
        <hr size='1' noshade>
        <br>
        <p>Vedlegg: <a href='vedlegg/".$row['linkVedlegg']."'>".$row['linkVedlegg']."</a> </p>
			</div>
		</div>";
    if($ferdig == 'Nei') {
        echo "<input type='image' src='img/edit.jpg' alt='Fortsett oppgave' title ='Fortsett oppgave' name='besvarelse' id='s".$PK."' />";
    }
	echo "</td></tr></form>";
 }


    echo  "<tbody></table></div>";
?>
