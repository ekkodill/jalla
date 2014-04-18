<?php 
//Denne siden er utviklet av Kurt A. Aamodt og Erik Bjørnflaten, siste gang endret 22.03.2014
//Denne siden er kontrollert av Mikael Kolstad siste gang 22.03.2014 !


include 'includes/init.php';
  
$db = getDB();

//Script for å laste opp vedlegg til serveren
if(isset($_FILES['file'])) {
$file = $_FILES["file"];
$fileID = $_POST['oppgPK'];

$allowedExts = array("pdf");
$temp = explode(".", $file["name"]);
$extension = end($temp);
if ((($file["type"] == "application/pdf") && in_array($extension, $allowedExts))) {
  if ($file["error"] > 0) {
     $errors[] = "Return Code: " . $file["error"] . "<br>";
    }
   else {
   $name = preg_replace("/[^A-Z0-9._-]/i", "_", $file["name"]); //Bytter ut "ulovlige" tegn med gyldige
   $parts = pathinfo($name);
   $name = $parts["filename"] . "-" . $fileID . "." . $parts["extension"]; //Setter oppgaveID på filnavnet

   if (file_exists("vedlegg/" . $name)) {
   $errors[] = $name . " filen finnes allerede. ";
   }
   if (strlen($name) > 46) { 
    $errors[] = "Navnet på vedlegget er for langt";
    }
   else {
    move_uploaded_file($file["tmp_name"], "vedlegg/" . $name);
    $stmt = $db->prepare("UPDATE oppgaver SET linkVedlegg=? WHERE oppgavePK = $fileID"); //Oppdaterer tabellen for linkVedlegg med filnavnet
    $stmt->bind_param('s', $name);
  
        if($stmt->execute()) {
            header("location: oppgave.php");
            die();
        } else { $errors[] = "Execute error"; }
    }
   }
 }
else {
   $errors[] = "Ugyldig filformat";
   }
} else {
$errors[] = "Du må velge et vedlegg å laste opp";
}

?>

<!doctype html>
<html>
    <?php include 'design/head.php'; ?>
    <body>
    <?php include 'design/header.php'; ?>
          <div id="page">
          
            <section style="width:94%">
                    <div class="midtfelt">
                    <?php
                        if (empty($errors) === false) {
                        ?><h2>Det oppstod en feil...</h2><?php
                        echo output_errors($errors);
                        }?>
                        <br>
                        <p><a href="oppgave.php">Gå tilbake til forrige side</a></p>
                    </div>
            </section>
            <?php include('design/footer.php'); ?>
        </div>
    </body>
</html>