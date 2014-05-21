<!--Denne siden er utviklet av Kurt A. Amodt., siste gang endret 20.04.2014
Denne siden er kontrollert av Erik Bjørnflaten siste gang 26.03.2014  !-->
<p># Antall som er utført og gitt tilbakemelding på</p>
<div class="oppliste"><table>
	     <thead>
		    <tr>
            <th>#</th>
		    	  <th class='tab2'>Veileder</th>
		        <th class='tab2'>Tittel</th>
		        <th class='tab2'>Dato endret</th>
		        <th class='tab2'>Link</th>
		        <th class='tab2'>Vanskelighetsgrad</th>
		        <th><input type="text" id="search" placeholder="  Søk"></input></th>
	    	</tr>
	    </thead>
    <tbody>
    <?php
/*******************************************************************************************************/
/********Denne siden lager en liste over oppgaver, vises på oppgave.php for veildere\admins****************/
/*******************************************************************************************************/
    
    $result = oppgListe("liste"); //Henter liste fra databasen gruppert på vanskelighetsgrad og sortert på dato
    while ($row = $result->fetch_assoc()) {
    
    $PK = $row['oppgavePK'];
    $antallOppg = antallUtfort("mrespons", $PK); //henter antall av denne oppgaven som har responser
    $vPK = $row['veileder'];
  	$veileder = finnBruker($vPK);
    $oppgtekst = hentOppgave($PK);
    $sanitized = nl2br(htmlspecialchars($oppgtekst, ENT_QUOTES));
    $vanskelighetsgrad = "ikke valgt";
    $publisert = $row['erPublisert'];
    $vedlegg = htmlspecialchars($row['linkVedlegg']);
    $tittel = htmlspecialchars($row['tittelOppgave']);

  	if ($row['vanskelighetsgrad'] === "3") {$vanskelighetsgrad = "Vanskelig"; }
    if ($row['vanskelighetsgrad'] === "2") {$vanskelighetsgrad = "Medium"; }
    if ($row['vanskelighetsgrad'] === "1") {$vanskelighetsgrad = "Lett";}
    if(!empty($antallOppg['antall'])) {
      $antallOppgMrespons = $antallOppg['antall'];
    } else {
      $antallOppgMrespons = "";
    }
    echo "<form action='' method='POST' id='upload".$PK."' enctype='multipart/form-data' >";
    echo "<tr>";
    echo "<td>".$antallOppgMrespons."</td>";
    echo "<td id='veileder".$PK."'      	 name='veileder'     >"	. $veileder.		      									 "</td>";
    echo "<td id='tittel".$PK."'        	 name='tittel'   		>"  . $tittel.									 "</td>";
    echo "<td id='datoendret".$PK."'    	 name='datoendret'  >"	. $row['datoEndret'].										 "</td>";
    echo "<td id='link".$PK."'    			 name='link'     	  	>   <a href='vedlegg/".$vedlegg."'>".$vedlegg."</a></td>";
    echo "<td id='vanskelighetsgrad".$PK."'  name='vanskelighetsgrad'   >"   . $vanskelighetsgrad. 										 "</td>";
   	echo "<input type='hidden' name='oppgPK' value=$PK />";

   	echo "<td><a href='#modalOppgli".$PK."'><img src='img/open.png' alt='Vis oppgaven' title='Vis oppgaven'></a>"; //Viser oppgaven
   	echo "<a href='#x' class='overlay' id='modalOppgli".$PK."'></a> 
    <div class='popup'>
      <h2>".$vedlegg."</h2>
        $sanitized
        <br>
        <br>
        <p>Vedlegg: <a href='vedlegg/".$vedlegg."'>".$vedlegg."</a> </p>
			<a class='close' href='#close'></a>
		</div>";
    //Skjuler knapper for deltakere, som er ment for admins\veiledere
  if($user_data['brukertype'] !=3) {
  echo "<input type='image'  src='img/uploadpdf.png' alt='Last opp vedlegg' title='Last opp vedlegg' id='f".$PK."'  name='ufil' onclick='doClick($PK); return false;' />"; //bildeknapp som åpner filvalgsmeny
	echo "<input id='file-input".$PK."' type='file' name='file' onchange='lagre($PK)' hidden/>"; //Filvalgsmeny
	echo "<input type='submit' hidden name='upload' id='s".$PK."' onclick=this.form.action='upload.php'; />"; //Lagrer vedlegget endringer
  if($publisert == 0) {
    //Publiseringsknapp
    echo "<input type='image' src='img/publish.png' name='poblish'  title='Publiser oppgave' alt='Publiser oppgave' onclick='publiser($PK); return false;' />";
    echo "<input type='submit' hidden  name='publish' id='p".$PK."' value=".$PK."  onclick=this.form.action='oppgave.php'; />";
    echo "<input type='hidden' name='oppgTittle' value=$tittel />";
    echo "<input type='hidden' name='oppgText' value='".$sanitized."' />";
    echo "<input type='hidden' name='vanskelighetsgrad' value='".$row['vanskelighetsgrad']."' />";
  }
  
  //Viser en knapp for deltakere for å utføre oppgaven
} elseif($user_data['brukertype'] == 3) {
  echo "<input type='hidden' name='tittel' value=$tittel/>";
  echo "<input type='hidden' name='oppgtxt' value=$sanitized/>";
  echo "<input type='image' src='img/edit.jpg' name='besvarelse' id='b".$PK."' onclick=this.form.action='skriv.php'; />";
}
	echo "</td></tr></form>";
 } 
    echo  "<tbody></table></div>";

?>
