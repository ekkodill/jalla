<?php 


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
}
echo date('Y-m-d h:i:s');
 ?>
<div>
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
		<th>Respons</th>
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
		<br><?php echo $innlevertTekst; ?></td></tr>
		<tr><td><h2>Oppgavetekst</h2>
		<h3>Tittel:<?php echo " ".$otittel ?></h3>
		<br><?php echo $otekst; ?></td></tr>
	</table>
</div>
<a href="minside.php">Gå tilbake</a>