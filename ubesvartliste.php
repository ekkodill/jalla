<?php 
//Denne siden er utviklet av Kurt A. Aamodt, siste gang endret 19.04.2014
//Denne siden er kontrollert av Mikael Kolstad siste gang 28.04.2014 

$bPK = $user_data['brukerPK'];
if(!empty($_SESSION['drpdwnlist'])) {
    if($_SESSION['drpdwnlist'] == 'ubesvoppg') {
      $result = ubesvarteOppg($bPK, 3);
    } elseif( $_SESSION['drpdwnlist'] =='pbegoppg') {
      $result = ubesvarteOppg($bPK, 0);
    } 
}else {
        $result = ubesvarteOppg($bPK, 3);
    }

while ($row = $result->fetch_assoc()) {
    $PK = $row['oppgavePK'];
    $innlPK = "";
    $gammelTid="";
    $lagrettext="";
    $tittel = $row['tittelOppgave'];
    $vPK = $row['veileder'];
    $veileder = finnBruker($vPK);
    $vedlegg = $row['linkVedlegg'];
    $vanskelighetsgrad = $row['vanskelighetsgrad'];
    $oppgtekst = hentOppgave($PK);
    $sanitized = nl2br(htmlspecialchars($oppgtekst, ENT_QUOTES));

  if(!empty($_POST) && $_SESSION['drpdwnlist'] =='pbegoppg') {
  $gammelTid = $row['tidBrukt'];
  $innlPK = $row['innleveringPK'];
  $lagrettext = $row['tekstInnlevering'];
} else { $_SESSION['drpdwnlist'] = 'ubesvoppg'; }

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
    echo "<td><a href='#openModal".$PK."'><img src='img/open.png' class='visoppgave' alt='Vis oppgaven' title='Vis oppgaven'></a>"; //Viser oppgaven
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
    
    echo "<input type='image' class='velgopg' src='img/edit.jpg' id='s".$PK."' title='Velg oppgave' />";
    echo "<input type='hidden' name='oppgPK' value='".$PK."'/>";
    echo "<input type='hidden' name='tittel' value=".$row['tittelOppgave']."/>";
    echo "<input type='hidden' name='oppgtxt' value='".$sanitized."'/>";
    echo "<input type='hidden' name='lagrettext' value='".$lagrettext."'/>";
    echo "<input type='hidden' name='innPK' value='".$innlPK."'/>";
    echo "<input type='hidden' name='gammelTid' value='".$gammelTid."'/>";

  echo "</td></tr></form>";
 }

 ?>

