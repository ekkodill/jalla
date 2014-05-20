<?php 
//Denne siden er utviklet av Kurt A. Aamodt, siste gang endret 19.04.2014
//Denne siden er kontrollert av Mikael Kolstad siste gang 28.04.2014 

/**********************************************************************************************************************************************/
/**************Denne filen viser liste med ubesvarte/uferdige oppgaver, både på skriv.php og minside.php for deltakere*******************/
/**********************************************************************************************************************************************/

while ($row = $result->fetch_assoc()) {
    $PK = $row['oppgavePK'];
    $innlPK = "";
    $gammelTid="";
    $sanitertinntxt="";
    $tittel = $row['tittelOppgave'];
    $vPK = $row['veileder'];
    $veileder = finnBruker($vPK);
    $vedlegg = $row['linkVedlegg'];
    $vanskelighetsgrad = $row['vanskelighetsgrad'];
    $oppgtekst = hentOppgave($PK);
    $sanitized = htmlspecialchars(trim($oppgtekst), ENT_QUOTES);
  if(!empty($row['tekstInnlevering']) /*&& $_SESSION['drpdwnlist'] =='pbegoppg'*/) {
  $gammelTid = $row['tidBrukt'];
  $innlPK = $row['innleveringPK'];
  $lagrettext = $row['tekstInnlevering'];
  $sanitertinntxt = nl2br(htmlspecialchars($lagrettext, ENT_QUOTES));
}

    if ($row['vanskelighetsgrad'] === "3") {$vanskelighetsgrad = "Vanskelig"; }
    if ($row['vanskelighetsgrad'] === "2") {$vanskelighetsgrad = "Medium"; }
    if ($row['vanskelighetsgrad'] === "1") {$vanskelighetsgrad = "Lett";}

    echo "<form class='ubesform' action='skriv.php' method='POST'>";
    echo "<tr>";
    echo "<td id='oppg".$PK."'  name='tittel'>";
    if(!empty($vedlegg)) {
      echo "<a href='vedlegg/".$vedlegg."'>". $row['tittelOppgave']." laget av ".$veileder." | ".$vanskelighetsgrad."</a>";
    } else {
      echo $row['tittelOppgave']." laget av ".$veileder ." | ".$vanskelighetsgrad;
    }
    echo "</td>";
    echo "<td><a href='#ubesoppg".$PK."'><img src='img/open.png' class='visoppgave' alt='Vis oppgaven' title='Vis oppgaven'></a>"; //Viser oppgaven
        echo "<a href='#x' class='overlay' id='ubesoppg".$PK."'></a>
        <div class='popup'>
          <h2>".$tittel."</h2>
          <div>
            $sanitized
            <br>
            <br>
            <p>Vedlegg: <a href='vedlegg/".$vedlegg."'>".$vedlegg."</a></p>
      </div><a class='close' href='#close'></a>
    </div>";
    if(empty($row['ferdig'])) {
    echo "<input style='background: none; border:none;' type='image' class='velgopg' src='img/edit.jpg' id='s".$PK."' title='Velg oppgave' />";
    }
    echo "<input type='hidden' name='oppgPK' value='".$PK."'/>";
    echo "<input type='hidden' name='tittel' value='".$row['tittelOppgave']."'/>";
    echo "<input type='hidden' name='oppgtxt' value='".$sanitized."'/>";
    echo "<input type='hidden' name='lagrettext' value='".$sanitertinntxt."'/>";
    echo "<input type='hidden' name='innPK' value='".$innlPK."'/>";
    echo "<input type='hidden' name='gammelTid' value='".$gammelTid."'/>";

  echo "</td></tr></form>";
 }

 ?>

