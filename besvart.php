<?php ini_set('display_errors', 'Off'); error_reporting(0); //Slår av alle php-errors 
protected_page();
?>
<!--Denne siden er utviklet av Kurt A. Amodt., siste gang endret 30.03.2014
Denne siden er kontrollert av Erik Bjørnflaten siste gang 30.03.2014  !-->
<div class="oppliste"><table style="border-collapse: collapse;">
	     <thead>
		    <tr>
		        <th  class='tab2'>Tittel</th>
		        <th  class='tab2'>Dato levert</th>
		        <th  class='tab2'>Tid brukt</th>
            <th  class='tab2'>Antall feil</th>
            <th  class='tab2'>Vedlegg</th>
            <th  class='tab2'>Ferdig</th>
            <th  class='tab2'>Valg</th>
	    	</tr>
	    </thead>
    <tbody>
    <?php
    /****************************************************************************************************************/
    /*******Denne siden brukes til å lage lister med besvarte oppgaver for deltakere som vises på minside.php*******/
    /******************************************************************************************************************/


while ($row = $result->fetch_assoc()) {
    $PK = $row['innleveringPK'];
    $oppgavePK = $row['oppgave'];
  	$innlevertTekst = $row['tekstInnlevering'];
    $oppgaveOtekst = $row['tekstOppgave'];
    $datoLevert = $row['datoLevert'];
    $tidBrukt = $row['tidBrukt'];
    $antFeil = $row['antallFeil'];
    $ferdig = $row['ferdig'];
    if(!empty($row['responsDato'])) {
        $datorespons = $row['responsDato'];
        $respons = $row['respons'];
    } else {
        $datorespons = "Ingen dato registrert";
        $respons = "Ingen respons enda";
    }
    
    if($ferdig == 1) { $ferdig = 'Ja'; } else { $ferdig = 'Nei'; }
    $sanitized = nl2br(htmlspecialchars($innlevertTekst, ENT_QUOTES));
    $oppgaveTekst = nl2br(htmlspecialchars($oppgaveOtekst, ENT_QUOTES));
    $vanskelighetsgrad = "ikke valgt";

  	if ($row['vanskelighetsgrad'] === "3") {$vanskelighetsgrad = "Vanskelig"; }
    if ($row['vanskelighetsgrad'] === "2") {$vanskelighetsgrad = "Medium"; }
    if ($row['vanskelighetsgrad'] === "1") {$vanskelighetsgrad = "Lett";}
 
    echo "<form action='print.php' method='POST'>";
    echo "<tr>";
    echo "<td id='tittel".$PK."'        	 name='tittel'     >"  . $row['tittelOppgave'].					"</td>";
    echo "<td id='datoLevert".$PK."'    	 name='datoLevert' >"  . $row['datoLevert'].					"</td>";
    echo "<td id='tidBrukt".$PK."'           name='tidBrukt'   >"  . $row['tidBrukt'].                      "</td>";
    echo "<td id='antFeil".$PK."'            name='antFeil'    >"  . $row['antallFeil'].                    "</td>";
    echo "<td id='link".$PK."'    			 name='link'       ><a href='vedlegg/".$row['linkVedlegg']."'>".$row['linkVedlegg']."</a></td>";
    echo "<td id='ferdig".$PK."'             name='ferdig'      >"  . $ferdig.                    "</td>";
   	echo "<input type='hidden' name='oppgPK' value=$oppgavePK />";
    echo "<input type='hidden' name='tittel' value='".$row['tittelOppgave']."'/>";
    echo "<input type='hidden' name='oppgtxt' value='".$oppgaveTekst."'/>";
    echo "<input type='hidden' name='lagrettext' value='".$sanitized."'/>";
    echo "<input type='hidden' name='datoLevert' value='".$datoLevert."'/>";
    echo "<input type='hidden' name='tidBrukt' value='".$tidBrukt."'/>";
    echo "<input type='hidden' name='antFeil' value='".$antFeil."'/>";
    echo "<input type='hidden' name='datorespons' value='".$datorespons."'/>";
    echo "<input type='hidden' name='respons' value='".$respons."'/>";
    
    //Viser oppgaven i en dialogboks med all informasjon om besvarelsen 
   	echo "<td><a href='#openResultat".$PK."'><img src='img/open.png' alt='Vis innleveringen' title='Vis innleveringen'></a>"; 
   	echo "<a href='#x' class='overlay' id='openResultat".$PK."'></a> 
            <div class='popup'>
                <h4>Utf&oslashrt den: ".$datoLevert."</h4>
                <h4>Vanskelighetsgrad: ".$vanskelighetsgrad."</h4> 
                <h4>Antall feil: ".$antFeil."</h4>
                <h4>Tid brukt: ".$tidBrukt."</h4>
                <br>
                <h4>Respons dato: ".$datorespons."</h4>
                Respons: ".$respons."
                <br>
                <br>
                <hr size='1' noshade>
				<h2>".$row['tittelOppgave']."</h2>
        		$sanitized
        <br><br><br>
        <hr size='1' noshade>
        <br>
        <p>Vedlegg: <a href='vedlegg/".$row['linkVedlegg']."'>".$row['linkVedlegg']."</a> </p>
		<a class='close' href='#close'></a>
		</div>";
        echo "<input type='image' class='print' src='img/respons.png' id='print".$PK."' title='Print' onclick=this.form.action='print.php';/>";

    //Dersom besvarelsen ikke er ferdig \ innlevert vises en knapp for å fortsette
    if($ferdig == 'Nei') {
        echo "<input type='image' src='img/edit.jpg' alt='Fortsett oppgave' title ='Fortsett oppgave' name='besvarelse' id='s".$PK."' />";
    }
	echo "</td></tr></form>";
 }


    echo  "<tbody></table></div>";
?>
