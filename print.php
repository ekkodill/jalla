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

<!--*******************************************************************-->
<!--**********Denne siden er for utskrift av innleverte oppgaver******-->
<!--*******************************************************************-->
<!doctype html>
<html>
<?php  include 'design/head.php'; ?>
<link href="css/print.css" media="print" rel="stylesheet" type="text/css">
<style type="text/css">
	ins {
    background-color: #c6ffc6;
    text-decoration: none;
}

del {
    background-color: #ffc6c6;
}

div, table, h3, input, label {
    margin: 10px;
}

table th {
    width: 30%;
}
</style>
<body>
<?php include 'design/header.php';  ?>
<?php
    $pgName = 'Besvarelse utskrift';
    ?>
    <div id="page">
        <section>
         <div>
         <br>
<table border="1" width="100%">
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
<table border="1" width="100%">
	<thead>
		<th>Respons ble gitt <?php echo " ".$datorespons ?></th>
	</thead>
		<tbody>
			<tr>
				<td><?php echo $respons ?></td>
			</tr>	
		</tbody>
</table>
<div id="wrapper">
	<table border="1" width="100%">
	  <thead>
            <tr>
                <th>Original</th>
                <th>Changed</th>
                <th>Diff</th>
            </tr>
        </thead>
		<tbody>
            <tr>
                <td class="original"><?php echo $otekst; ?></td>
                <td class="changed"><?php echo $innlevertTekst; ?></td>
                <td class="diff"></td>
            </tr>
        </tbody>
	</table>
</div>
</div>   
<a href="minside.php">Gå tilbake</a>
        </section>
    </div>
    <?php include('design/footer.php'); ?>
    
    <script type="text/javascript">
    $(document).ready(function () {
    $("#wrapper tr").prettyTextDiff({
        cleanup: $("#cleanup").is(":checked")
    });
});</script>
  </body>
</html>
