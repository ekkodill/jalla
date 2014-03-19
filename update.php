<?php
// Denne siden er utviklet av Erik Bjørnflaten og Kurt A. Aamodt., siste gang endret 03.03.2014
// Denne siden er kontrollert av Mikael Kolstad, iste gang endret 03.03.2014

require_once("includes/connect.php");
$db = getDB();


  if(isset($_POST['lagreupdate'])) {
  //Gjør om brukertypen fra nedtrekksmenyen til riktig tall.
    if($_POST['btype'] == "administrator") { 
      $type = 1; 
    } 
      else if($_POST['btype'] == "veileder" ) { 
      $type = 2; 
    }
      else if($_POST['btype'] == "deltaker") { 
      $type = 3; 
    }
    $epost = $_POST['ePost'];
    $etternavn = $_POST['etternavn'];
    $fornavn = $_POST['fornavn'];
    $brukerPK = $_POST['brukerPK'];
    
    $stmt = $db->prepare("UPDATE brukere SET ePost=?, etternavn=?, fornavn=?, brukertype=? WHERE brukerPK=? LIMIT 1");
  $stmt->bind_param('sssis', $epost, $etternavn, $fornavn, $type, $brukerPK);
  

if($stmt->execute()) {
        
      header('Location: vis_brukere.php');  
      } else  { 
        echo "Noe gikk galt" ;
      }       
      } else { 
        echo "noPOST";
      }

  ?>

