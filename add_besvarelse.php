<?php 
$db = getDB();
if(!empty($_POST['lagreoppg']) || !empty($_POST['fullor'])) {
if(!empty($tittel) || !empty($oppg))  {
        $tittel     = $_POST['tittel'];
        $oppg       = $_POST['oppg'];
        $bruker     = $user_data['brukerPK'];
        $oppgavenr  = $_POST['oppgavePK'];
        $antFeil    = 0;
        $ferdig     = 0;
        $tidBrukt = $_POST['tid'];
        if(isset($_POST['fullor'])) { 
            $ferdig = 1;
        }
            
        
                $insert = $db->prepare("INSERT INTO innleveringer (bruker, oppgave, tekstInnlevering, datoLevert, tidBrukt, antallFeil, ferdig) VALUES (?,?,?,now(),?,?,?)");
                $insert->bind_param('iissii', $bruker, $oppgavenr, $oppg, $tidBrukt, $antFeil, $ferdig);
        
                if($insert->execute()) {
                    header('Location: skriv.php');
                    die();
                }
        }
}

 ?>
