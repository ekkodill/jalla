<!--Denne siden er utviklet av Erik Bjørnflaten (html\css) og Mikael Kolstad (JS) Kurt A. Aamodt (php), siste gang endret 29.04.2014
Denne siden er kontrollert av Dag-Roger Eriksen siste gang 29.05.2014  !-->
<?php 
include 'includes/init.php'; 
ini_set('display_errors', 'Off'); error_reporting(0); //Slår av alle php-errors 
protected_page();

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
<?php
    $pgName = 'Besvarelse utskrift';
    ?>
<?php  include 'design/head.php'; ?>
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

/*Justeringer for tabellene*/
table {
    margin-top: 10px;
    margin-bottom: 10px;
    border-collapse: collapse;
    border-color:#5B5B5B ;

}

td {
    padding:0;
    margin: 0;
    vertical-align: text-top;
}
th {
    min-width:90px;
    background: #5B5B5B;
    color: white;
    text-align: left;
    vertical-align: left;
    border-color:#5B5B5B ;
}

/*Lager mellomrom mellom oppgavetekst og besvarelsen*/
tr.spaceing > td {
    padding-bottom:4%;
    display: hidden;
    border-left:0;
    border-right:0;
    border-top:0;
    border-bottom:1;
}

</style>
<link href="css/print.css" media="print" rel="stylesheet" type="text/css">
<body>
<?php include 'design/header.php';  ?>
        <section>
        <!--Table som viser data om besvarelsen-->
        <h3 class="proinffo">Resultatside med sammenligning</h3><br>
            <table class="printtable">
            	<thead>
            		<th>Tid brukt</th>
            		<th>Antall feil</th>
            		<th>Dato levert</th>
                    <th>Respons dato</th>
            	</thead>
            		<tbody>
            			<tr>
            				<td><?php echo $tidBrukt ?></td>
            				<td><?php echo $antFeil ?></td>
            				<td><?php echo $datoLevert ?></td>
                            <td><?php echo $datorespons ?></td>
            			</tr>	
            		</tbody>
            </table>
            <div class="printcss">
                <?php if($respons == "Ingen respons enda") {
                	echo "Ingen respons registrert på denne innleveringen";
                } else {

                 ?>
                <!--Table som viser respons-->
                <table class="printtable">
                		<tbody>
                        <th>Respons</th>
                			<tr>
                				<td><?php echo $respons ?></td>
                			</tr>	
                		</tbody>
                </table>
                    <?php 
                    }
                     ?>
            </div>
            <div class="printcss">
                <div id="wrapper">
                <!--Table som viser tittel, original oppgavetekst og besvarelsen markert med feil-->
                	<table class="printtable">
                	   <thead>
                            <th class="printfont">Tittel:</th>
                            <th ><?php echo $otittel; ?></th>
                        </thead>
                		<tbody>
                			<tr><td class="printfont"><b>Original tekst:</b></td><td><?php echo $otekst; ?></td></tr>
                            <tr class="spaceing"><td></td><td></td></tr>
                            <tr>
                                <td class="original" hidden><?php echo $otekst; ?></td>
                                <td class="changed" hidden><?php echo $innlevertTekst; ?></td>
                                <td class="printfont"><b>Innlevert tekst:</b></td><td class="diff"></td>
                            </tr>
                        </tbody>
                	</table>
                </div>
            </div>
            <div class="printcss">
            <?php 
            //Viser forklaring for fargekodene dersom det er feil i besvarelsen
            if($antFeil != 0) { ?>
                <p><span class="printfont"><b>Fargekoder:</b></span><br>
                <span style="background:#c6ffc6">Grønn er karakterer som var glemt, og satt inn av maskinen da de skulle vært med.</span><br>
                <span style="background:#ffc6c6"><u>Rød og understrek er karakterer som ikke skulle vært med.</u></span></p>
            <?php } ?>
            </div><br>
            <a href="minside.php">Gå tilbake</a>
            <br class="clear" />
        </section> 
    <script type="text/javascript">
    //Script for å finne forskjellene i teksten og sette styling på de\rette opp
    //Kode hentet fra internett, url: https://github.com/arnab/jQuery.PrettyTextDiff
    $(document).ready(function () {
        $("#wrapper tr").prettyTextDiff({
            cleanup: $("#cleanup").is(":checked")
        });
    });
    </script>
  <?php include('design/footer.php'); ?>
  </body>
</html>
