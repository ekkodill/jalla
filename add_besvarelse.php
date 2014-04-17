<?php 
include_once 'includes/init.php';
$db = getDB();


if(!empty($_POST['lagreoppg']) || !empty($_POST['fullfor'])) {
    if(!empty($_POST['inntext']) && !empty($_POST['tid']) && !empty($_SESSION['oppgPK'])) {
        $bruker     = $user_data['brukerPK'];
        $oppgavenr  = $_SESSION['oppgPK'];
        $oppg       = $_POST['inntext'];
        $_SESSION['inntxt'] = $oppg;
        $tid        =  substr($_POST['tid'],0,-4); //fjerner millisekunder
        $tidBrukt   = date_create_from_format('H:i:s', $tid); //gjør det om til en datetime format objekt
        $mySqlTime  = date('H:i:s', $tidBrukt->getTimestamp()); //gjør datetime objektet om til mysql time format
        $_SESSION['antfeil'] = (strlen($_SESSION['oppgtxt']) - similar_text($_SESSION['inntxt'], $_SESSION['oppgtxt']));
        $antFeil    = $_SESSION['antfeil'];
        $ferdig     = 0; 
        $_SESSION['tid'] = $tid;
        if(!empty($_POST['fullfor'])) { 
            $ferdig = 1;
        }
          
                $insert = $db->prepare("INSERT INTO innleveringer (bruker, oppgave, tekstInnlevering, datoLevert, tidBrukt, antallFeil, ferdig) VALUES (?,?,?,now(),?,?,?)");
                $insert->bind_param('iissii', $bruker, $oppgavenr, $oppg, $mySqlTime, $antFeil, $ferdig);
        
                if($insert->execute()) {
                   similar_text($_SESSION['oppgtxt'], $_SESSION['inntxt'], $percent);
                    $_SESSION['percent'] = round($percent);
                   
                    header('Location: skriv.php');
                    die();
                }
    } else { redirect("skriv.php"); }
}
    

 ?>
