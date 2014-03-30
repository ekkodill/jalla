<!--Denne siden er utviklet av Kurt A. Amodt., siste gang endret 30.03.2014
Denne siden er kontrollert av Erik Bjørnflaten siste gang 23.03.2014  !-->
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
    $result = $db->query("SELECT * FROM oppgaver") ;
    while ($row = $result->fetch_assoc()) {
    $PK = $row['oppgavePK'];
    $vPK = $row['veileder'];
    $oppgtekst = hentOppgave($PK);
  	$veileder = finnBruker($vPK);
  	$sanitized = nl2br(htmlspecialchars($oppgtekst, ENT_QUOTES));


  	if ($row['vanskelighetsgrad'] === "3") {$vanskelighetsgrad = "Vanskelig"; }
    if ($row['vanskelighetsgrad'] === "2") {$vanskelighetsgrad = "Medium"; }
    if ($row['vanskelighetsgrad'] === "1") {$vanskelighetsgrad = "Lett";}

    echo "<form action='upload.php' method='POST' id='upload".$PK."' enctype='multipart/form-data' >";
    echo "<tr>";
    echo "<td id='veileder".$PK."'      	 name='veileder'     >"	. $veileder.		      									 "</td>";
    echo "<td id='tittel".$PK."'        	 name='tittel'   		>"  . $row['tittelOppgave'].									 "</td>";
    echo "<td id='datoendret".$PK."'    	 name='datoendret'  >"	. $row['datoEndret'].										 "</td>";
    echo "<td id='link".$PK."'    			 name='link'     	  	>   <a href='vedlegg/".$row['linkVedlegg']."'>".$row['linkVedlegg']."</a></td>";
    echo "<td id='vanskelighetsgrad".$PK."'  name='vanskelighetsgrad'   >"   . $vanskelighetsgrad. 										 "</td>";
   	echo "<input type='hidden' name='oppgPK' value=$PK />";

   	echo "<td><a href='#openModal".$PK."'><img src='img/open.png' alt='Vis oppgaven' title='Vis oppgaven'></a>"; //Viser oppgaven
   	echo "<div id='openModal".$PK."' class='modalDialog'>
			<div>
				<a href='#close' title='Close' class='close'>X</a>
				<h2>".$row['tittelOppgave']."</h2>
				$sanitized
        <br>
        <br>
        <p>Vedlegg: <a href='vedlegg/".$row['linkVedlegg']."'>".$row['linkVedlegg']."</a> </p>
			</div>
		</div>";
  if($user_data['brukertype'] !=3) {
  echo "<input type='image'  src='img/pdf.jpg' alt='Last opp vedlegg' title='Last opp vedlegg' id='f".$PK."'  name='ufil' onclick='doClick($PK); return false;' />"; //bildeknapp som åpner filvalgsmeny
	echo "<input id='file-input".$PK."' type='file' name='file' onchange='lagre($PK)' hidden/>"; //Filvalgsmeny
	echo "<input type='submit' hidden name='upload' id='s".$PK."' onclick=this.form.action='upload.php'; />"; //Lagrer vedlegget endringer
}
	echo "</td></tr></form>";
 } 
    echo  "<tbody></table></div>";
?>
