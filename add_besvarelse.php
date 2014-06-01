<?php 
//Denne siden er utviklet av Kurt A. Aamodt, siste gang endret 04.05.2014
//Denne siden er kontrollert av Erik Bjørnflaten siste gang 29.05.2014 

include_once 'includes/init.php';
protected_page();
$db = getDB();


/**************************************************************************/
/*******Denne filen legger til eller oppdaterer besvarelser i databasen*****/
/***************************************************************************/

if(!empty($_POST['lagreoppg']) || !empty($_POST['fullfor'])) {
    if(!empty($_POST['inntext']) && !empty($_POST['tid']) && !empty($_SESSION['oppgPK'])) {
        $bruker     = $user_data['brukerPK'];
        $oppgavenr  = $_SESSION['oppgPK'];
        $oppg       = trim($_POST['inntext']);
        $_SESSION['inntxt'] = $oppg;
        $tid        =  substr($_POST['tid'],0,-4); //fjerner millisekunder
        $tidBrukt   = date_create_from_format('H:i:s', $tid); //gjør det om til en datetime format objekt
        $mySqlTime  = date('H:i:s', $tidBrukt->getTimestamp()); //gjør datetime objektet om til mysql time format
        $_SESSION['antfeil']  =  $_POST['jsfeil']; //Får antall feil fra JS compareString 
        $antfeil    = $_SESSION['antfeil'];
        $ferdig     = 0; 
        $melding = "lagret";
        if(!empty($_POST['fullfor'])) {
            $ferdig = 1;
            $melding = "innlevert";
        } 
        
        $_SESSION['tid'] = $tid; 
        similar_text($_SESSION['oppgtxt'], $_SESSION['inntxt'], $percent); //sammenligner tekstene (orginal og levering) og regner ut feilprosenten
        $_SESSION['percent'] = round($percent);

        //Sjekker om man skal levere en tidligere påbegynnt oppgave og oppdaterer med ny info i databasen. Eller oppdater ny lagring av  tidligere påbegynnt oppgave
         if(sjekkAntall("innleveringer WHERE oppgave = ".$oppgavenr." AND bruker = ".$bruker)) {
            $innPK     = $_SESSION['innlPK'];
            $gammelTid = $_SESSION['gammelTid'];
            $secs = strtotime($gammelTid)-strtotime("00:00:00"); //Gjør om til sekunder
            $result = date("H:i:s",strtotime($mySqlTime)+$secs); //Legger på sekundene til den nye tiden
            $_SESSION['tid'] = $result;
      
            $stmt = $db->prepare("UPDATE innleveringer SET tekstInnlevering=?, datoLevert=now(), tidBrukt=?, antallFeil=?, ferdig=? WHERE innleveringPK=? LIMIT 1");
            $stmt->bind_param('ssiii', $oppg,$result, $antfeil, $ferdig, $innPK );
             if($stmt->execute()) {
                header('Location: skriv.php?'.$melding);
                die();
             } else { 
                header('Location: skriv.php?error');
                die();
            }
        } else {
            //Lagrer innleveringer i databasen
                $insert = $db->prepare("INSERT INTO innleveringer (bruker, oppgave, tekstInnlevering, datoLevert, tidBrukt, antallFeil, ferdig) VALUES (?,?,?,now(),?,?,?)");
                $insert->bind_param('iissii', $bruker, $oppgavenr, $oppg, $mySqlTime, $antfeil, $ferdig);
                if($insert->execute()) {                  
                    header('Location: skriv.php?'.$melding);
                    die();
                }  else { 
                    header('Location: skriv.php?error');
                    die();
                }
        }
    
}  else { redirect("skriv.php"); }
}  
 ?>
