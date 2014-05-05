<!--Denne siden er utviklet av Erik Bjørnflaten (html\css) og Mikael Kolstad (JS) Kurt A. Aamodt (php), siste gang endret 29.04.2014
Denne siden er kontrollert av Dag-Roger Eriksen siste gang 04.05.2014  !-->
<?php include 'includes/init.php'; 

//Får data fra besvart listen til brukeren og setter verdiene i variabler
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

/*Setter farge på karakterer i teksta som ikke er med i orginalen*/
ins {
    background-color: #ffc6c6;
   
}

/*Setter farge på karakterer i teksta som er fjernet, men er med i orginalen*/
del {
	background-color: #c6ffc6;
    text-decoration: none;

}

div, table, h3, input, label {
    margin: 10px;
}


</style>
<body>
<?php include 'design/header.php';  ?>
<?php
    $pgName = 'Besvarelse utskrift';
    ?>
    <div id="page">
        <section>
        <!--Table som viser data om besvarelsen-->
            <table>
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
                <?php if($respons == "Ingen respons enda") {
                	echo "Ingen respons registrert på denne innleveringen";
                } else {

                 ?>
            <!--Table som viser data om besvarelsen-->
            <table>
            	<thead>
            		<th>Respons dato: <?php echo " ".$datorespons ?></th>
            	</thead>
            		<tbody>
            			<tr>
            				<td><?php echo $respons ?></td>
            			</tr>	
            		</tbody>
            </table>
                <?php 
                }
                 ?>
            <div id="wrapper">
            <!--Table som viser tittel, original oppgavetekst og besvarelsen markert med feil-->
            	<table>
            	   <thead>
                        <th>Tittel:</th>
                        <th><?php echo $otittel; ?></th>
                    </thead>
            		<tbody>
            			<tr><td>Original tekst</td><td><?php echo $otekst; ?></td></tr>
                        <tr>
                            <td class="original" hidden><?php echo $otekst; ?></td>
                            <td class="changed" hidden><?php echo $innlevertTekst; ?></td>
                            <td>Innlevert tekst</td><td class="diff"></td>
                        </tr>
                    </tbody>
            	</table>
            </div>
            <a href="minside.php">Gå tilbake</a>
        </section>
    </div>
    <?php include('design/footer.php'); ?>
    
    <script type="text/javascript">
    //Script for å finne forskjellene i teksten og sette styling på de\rette opp
    //Kode hentet fra internett, url: https://github.com/arnab/jQuery.PrettyTextDiff
    $(document).ready(function () {
        $("#wrapper tr").prettyTextDiff({
            cleanup: $("#cleanup").is(":checked")
        });
    });
    </script>
  </body>
</html>
