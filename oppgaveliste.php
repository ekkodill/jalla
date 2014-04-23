<!--Denne siden er utviklet av Kurt A. Amodt., siste gang endret 20.04.2014
Denne siden er kontrollert av Erik Bjørnflaten siste gang 26.03.2014  !-->

<div class=bliste><table>
	     <thead>
		    <tr>
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


    $result = oppgListe("liste"); //Henter liste fra databasen gruppert på vanskelighetsgrad og sortert på dato
    while ($row = $result->fetch_assoc()) {
    $PK = $row['oppgavePK'];
    $vPK = $row['veileder'];
  	$veileder = finnBruker($vPK);
    $oppgtekst = hentOppgave($PK);
    $sanitized = nl2br(htmlspecialchars($oppgtekst, ENT_QUOTES));
    $vanskelighetsgrad = "ikke valgt";
    $publisert = $row['erPublisert'];
   /* if(!empty($row['erPublisert'])) {
      
    }*/
    $vedlegg = htmlspecialchars($row['linkVedlegg']);
    $tittel = htmlspecialchars($row['tittelOppgave']);

  	if ($row['vanskelighetsgrad'] === "3") {$vanskelighetsgrad = "Vanskelig"; }
    if ($row['vanskelighetsgrad'] === "2") {$vanskelighetsgrad = "Medium"; }
    if ($row['vanskelighetsgrad'] === "1") {$vanskelighetsgrad = "Lett";}
    
    echo "<form action='' method='POST' id='upload".$PK."' enctype='multipart/form-data' >";
    echo "<tr>";
    echo "<td id='veileder".$PK."'      	 name='veileder'     >"	. $veileder.		      									 "</td>";
    echo "<td id='tittel".$PK."'        	 name='tittel'   		>"  . $tittel.									 "</td>";
    echo "<td id='datoendret".$PK."'    	 name='datoendret'  >"	. $row['datoEndret'].										 "</td>";
    echo "<td id='link".$PK."'    			 name='link'     	  	>   <a href='vedlegg/".$vedlegg."'>".$vedlegg."</a></td>";
    echo "<td id='vanskelighetsgrad".$PK."'  name='vanskelighetsgrad'   >"   . $vanskelighetsgrad. 										 "</td>";
   	echo "<input type='hidden' name='oppgPK' value=$PK />";

   	echo "<td><a href='#openModal".$PK."'><img src='img/open.png' alt='Vis oppgaven' title='Vis oppgaven'></a>"; //Viser oppgaven
   	echo "<div id='openModal".$PK."' class='modalDialog'>
			<div>
				<a href='#close' title='Close' class='close'>X</a>
				<h2>".$vedlegg."</h2>
				$sanitized
        <br>
        <br>
        <p>Vedlegg: <a href='vedlegg/".$vedlegg."'>".$vedlegg."</a> </p>
			</div>
		</div>";
  if($user_data['brukertype'] !=3) {
  echo "<input type='image'  src='img/pdf.jpg' alt='Last opp vedlegg' title='Last opp vedlegg' id='f".$PK."'  name='ufil' onclick='doClick($PK); return false;' />"; //bildeknapp som åpner filvalgsmeny
	echo "<input id='file-input".$PK."' type='file' name='file' onchange='lagre($PK)' hidden/>"; //Filvalgsmeny
	echo "<input type='submit' hidden name='upload' id='s".$PK."' onclick=this.form.action='upload.php'; />"; //Lagrer vedlegget endringer
  if($publisert == 0) {
    //Publiseringsknapp
    echo "<input type='image' src='img/publish.png' name='poblish'  title='Publiser oppgave' alt='Publiser oppgave' onclick='publiser($PK); return false;' />";
    echo "<input type='submit' hidden  name='publish' id='p".$PK."' value=".$PK."  onclick=this.form.action='oppgave.php'; />";
    echo "<input type='hidden' name='oppgTittle' value=$tittel />";
    echo "<input type='hidden' name='oppgText' value='".$sanitized."' />";
    echo "<input type='hidden' name='vanskelighetsgrad' value='".$row['vanskelighetsgrad']."' />";
    //Viser besvarelsen i en dialogboks med inputfelt for responen
   /* echo "<a href='#editModal".$PK."'><img src='img/publish.png' title='Publiser oppgave' alt='Publiser oppgave'></a>"; 
    echo "<div id='editModal".$PK."' class='modalDialog'>
      <div>
        <a href='#close' title='Close' class='close'>X</a>
        <h2>$tittel</h2>
        <br>
        <textarea id='editoppg' name='respons'>$sanitized</textarea>
        <br>
        <input type='button' value='Lagre' name='editsave'/>
        <input type='button' value='Publiser' name='editpublish'/>
        <input type='checkbox' name='editcheck'>Send mail om denne publiseringen
        <input id='editoppg".$PK."' type='submit' hidden name='saveedit'>
      </div>
    </div>"; */
  }
  
} elseif($user_data['brukertype'] == 3) {
  echo "<input type='hidden' name='tittel' value=$tittel/>";
  echo "<input type='hidden' name='oppgtxt' value=$sanitized/>";
  echo "<input type='image' src='img/edit.jpg' name='besvarelse' id='b".$PK."' onclick=this.form.action='skriv.php'; />";
}
	echo "</td></tr></form>";
 } 
    echo  "<tbody></table></div>";

?>
