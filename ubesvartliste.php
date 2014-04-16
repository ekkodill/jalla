<table class="ubesform">
	<tbody>
<?php 

$bPK = $user_data['brukerPK'];
$result = ubesvarteOppg($bPK);
while ($row = $result->fetch_assoc()) {
    $PK = $row['oppgavePK'];
    $tittel = $row['tittelOppgave'];
    $vPK = $row['veileder'];
    $veileder = finnBruker($vPK);
    $vedlegg = $row['linkVedlegg'];
    $vanskelighetsgrad = $row['vanskelighetsgrad'];
	$oppgtekst = hentOppgave($PK);
	$sanitized = nl2br(htmlspecialchars($oppgtekst, ENT_QUOTES));
    if ($row['vanskelighetsgrad'] === "3") {$vanskelighetsgrad = "Vanskelig"; }
    if ($row['vanskelighetsgrad'] === "2") {$vanskelighetsgrad = "Medium"; }
    if ($row['vanskelighetsgrad'] === "1") {$vanskelighetsgrad = "Lett";}

    echo "<form class='ubesform' action='' method='POST'>";
    echo "<tr>";
    echo "<td id='oppg".$PK."'  name='tittel'>";
    if(!empty($vedlegg)) {
      echo "<a href='vedlegg/".$vedlegg."'>". $row['tittelOppgave']." laget av ".$veileder." | ".$vanskelighetsgrad."</a>";
    } else {
      echo $row['tittelOppgave']." laget av ".$veileder ." | ".$vanskelighetsgrad;
    }
    echo "</td>";
   	echo "<td><a href='#openModal".$PK."'><img src='img/open.png' alt='Vis oppgaven' title='Vis oppgaven'></a>"; //Viser oppgaven
   	   	echo "<div id='openModal".$PK."' class='modalDialog'>
			<div>
				<a href='#close' title='Close' class='close'>X</a>
				<h2>".$tittel."</h2>
				$sanitized
        		<br>
        		<br>
        		<p>Vedlegg: <a href='vedlegg/".$vedlegg."'>".$vedlegg."</a></p>
			</div>
		</div>";
   	
   	echo "<input type='image' src='img/edit.jpg' id='s".$PK."'/>";
    echo "<input type='hidden' name='oppgPK' value='".$PK."'/>";
    echo "<input type='hidden' name='tittel' value=".$row['tittelOppgave']."/>";
    echo "<input type='hidden' name='oppgtxt' value='".$sanitized."'/>";
	echo "</td></tr></form>";
 }

 ?>
	<tbody>
</table>
