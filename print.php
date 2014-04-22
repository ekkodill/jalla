<!--Denne siden er utviklet av Erik Bjørnflaten og Dag-Roger Eriksen, siste gang endret 03.03.2014
Denne siden er kontrollert av Kurt A. Aamodt siste gang 03.03.2014  !-->
<?php include 'includes/init.php'; 

if (!empty($_POST)) {
    if(!empty($_POST['tittel']) && !empty($_POST['oppgtxt']) && !empty($_POST['lagrettext'])) {
	$otittel = $_POST['tittel'];
	$otekst = $_POST['oppgtxt'];
  	$innlevertTekst = $_POST['lagrettext'];
    $datoLevert = $_POST['datoLevert'];
    $tidBrukt = $_POST['tidBrukt'];
    $antFeil = $_POST['antFeil'];
    $datorespons = $_POST['datorespons'];
    $respons = $_POST['respons'];
}
} else {
$otittel = "";
$otekst = "";
$innlevertTekst = "";
$datoLevert = "";
$tidBrukt = "";
$antFeil = "";
$datorespons = "";
$respons = "";
}
?>
<!doctype html>
<html>
<body onunload="unloadP('skriv');" onload="loadP('skriv');">
<?php
    $pgName = 'Besvarelse utskrift';
   include 'design/head.php'; ?>
<?php include 'design/header.php';  ?>
    <div id="page">
        <section>
         <div>
         <br>
<table border="1" width="400">
	<thead>
		<th>Tid brukt</th>
		<th>Antall feil</th>
		<th>Dato levert</th>
	</thead>
		<tbody>
			<tr>
				<td><?php echo $tidBrukt ?></td>
				<td><?php echo $antFeil ?></td>
				<td><?php echo $datoLevert ?></td>
			</tr>	
		</tbody>
</table>
<table border="1" width="400">
	<thead>
		<th>Respons ble gitt <?php echo " ".$datorespons ?></th>
	</thead>
		<tbody>
			<tr>
				<td><?php echo $respons ?></td>
			</tr>	
		</tbody>
</table>
	<table border="1" width="400">
		<tr><td><h2>Innlevert oppgavetekst</h2>
		<h3>Tittel:<?php echo " ".$otittel ?></h3>
		<br><?php echo $innlevertTekst; ?></td>
		<td><h2>Oppgavetekst</h2>
		<h3>Tittel:<?php echo " ".$otittel ?></h3>
		<br><?php echo $otekst; ?></td></tr>
	</table>
</div>
<a href="minside.php">Gå tilbake</a>
        </section>
    </div>
    <?php include('design/footer.php'); ?>
  </body>
</html>
