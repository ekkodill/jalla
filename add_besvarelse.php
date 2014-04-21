<?php 
//Denne siden er utviklet av Kurt A. Aamodt, siste gang endret 19.04.2014
//Denne siden er kontrollert av Mikael Kolstad siste gang 28.04.2014 

include_once 'includes/init.php';
$db = getDB();


if(!empty($_POST['lagreoppg']) || !empty($_POST['fullfor'])) {
    if(!empty($_POST['inntext']) && !empty($_POST['tid']) && !empty($_SESSION['oppgPK'])) {
        $bruker     = $user_data['brukerPK'];
        $oppgavenr  = $_SESSION['oppgPK'];
        $oppg       = trim($_POST['inntext']);
        $_SESSION['inntxt'] = $oppg;
        $tid        =  substr($_POST['tid'],0,-4); //fjerner millisekunder
        $tidBrukt   = date_create_from_format('H:i:s', $tid); //gjør det om til en datetime format objekt
        $mySqlTime  = date('H:i:s', $tidBrukt->getTimestamp()); //gjør datetime objektet om til mysql time format
        $_SESSION['antfeil']  = (strlen($_SESSION['oppgtxt']) - similar_text($_SESSION['inntxt'], $_SESSION['oppgtxt'])); //sammenligner original tekst med innlever og regner ut antall feil
        $antfeil    = $_SESSION['antfeil'];
        $ferdig     = 0; 
        $_SESSION['tid'] = $tid; 
        similar_text($_SESSION['oppgtxt'], $_SESSION['inntxt'], $percent); //sammenligner tekstene (orginal og levering) og regner ut feilprosenten
        $_SESSION['percent'] = round($percent);

        //Sjekker om man skal levere en tidligere påbegynnt oppgave og oppdaterer med ny info i databasen
        if(!empty($_POST['fullfor']) || !empty($_POST['lagreoppg']) && $_SESSION['drpdwnlist'] =='pbegoppg') {
            if(!empty($_POST['fullfor'])) {
                $ferdig = 1;
            }
            $innPK      = $_SESSION['innlPK'];
            $gammelTid = $_SESSION['gammelTid'];
            $secs = strtotime($gammelTid)-strtotime("00:00:00"); //Gjør om til sekunder
            $result = date("H:i:s",strtotime($mySqlTime)+$secs); //Legger på sekundene til den nye tiden
            $_SESSION['tid'] = $result;
            
            $query = "
                UPDATE innleveringer 
                    SET bruker = $bruker, oppgave = $oppgavenr, tekstInnlevering ='".$oppg."', datoLevert=now(), tidBrukt ='".$result."', antallFeil = $antfeil, ferdig = $ferdig 
                    WHERE innleveringPK = $innPK LIMIT 1";

        if($db->query($query)) {
            redirect("skriv.php");
            } else { echo $query;}
        } else {
            //Lagrer innleveringer i databasen
                if(!empty($_POST['fullfor'])) {
                    $ferdig = 1;
                }
                $insert = $db->prepare("INSERT INTO innleveringer (bruker, oppgave, tekstInnlevering, datoLevert, tidBrukt, antallFeil, ferdig) VALUES (?,?,?,now(),?,?,?)");
                $insert->bind_param('iissii', $bruker, $oppgavenr, $oppg, $mySqlTime, $antfeil, $ferdig);
        
                if($insert->execute()) {                  
                    header('Location: skriv.php');
                    die();
                }  else { redirect("skriv.php"); }
        }
    
}  else { redirect("skriv.php"); }
}  
 ?>
