<!--Denne siden er utviklet av Erik Bjørnflaten, siste gang endret 30.04.2014
Denne siden er kontrollert av Kurt A. Aamodt siste gang 30.04.2014  !-->
<?php 
include_once 'includes/init.php';
protected_page();
$db = getDB(); //Tilkobling til databasen.

?>

<!--********************************************************************************-->
<!--**********Denne siden er for å legge til \ vise brukerliste*********************-->
<!--********************************************************************************-->

<!DOCTYPE html>
<html lang="nb-no">
<?php
	$pgName = 'Vis brukere';
	include('design/head.php');
 ?>
	<body onload='loadP("visbrukere");' onunload='unloadP("visbrukere")'>
<?php include('design/header.php');	?>

<script type="text/javascript">

//Kodet hentet fra internett, url: http://www.thomashardy.me.uk/using-html5-localstorage-on-a-form
//Fyller feltene med data fra localStorage om det er noe der når siden lastes
$(document).ready(function () {
function init() {
    if (localStorage["ePost"]) {
        $('#ePost').val(localStorage["ePost"]);
    }
    if (localStorage["etternavn"]) {
        $('#etternavn').val(localStorage["etternavn"]);
    }
    if (localStorage["fornavn"]) {
        $('#fornavn').val(localStorage["fornavn"]);
    }
    if (localStorage["btype"]) {
        $('#nytype').val(localStorage["btype"]);
    }
}
$('.tarea').keyup(function () {
    localStorage[$(this).attr('id')] = $(this).val();
});
init();


//Resetter feltene når formen blir sendt uten problemer
$('#nybruker').submit(function() {
	localStorage.clear();
});
	
//Lagrer feltenes innhold til localstorage
$('.tarea').keyup(function () {
    localStorage[$(this).attr('id')] = $(this).val();
});

//Lagrer nedtrekksmenyens verdi til localStorage
$(document).ready(function(){
    $('#nytype').change(function(){
         localStorage.setItem('btype', $(this).val());
         $('#nytype').value(localStorage.getItem('btype'));
    });
})

});

//Fjerner brukertyper fra nedtrekksmenyen slik at den innloggede bare kan gi rettigheter ut fra hvilken brukertype han selv er
$(document).ready(function () {
		fjernType(<?php echo $user_data['brukertype']; ?>, "nytype");
});

</script>
			<div id="page">
			   <section>
			   
		       	<?php
		       	//Inkluderer elementene for admins\veiledere å legge til brukere
		       	if($user_data['brukertype'] != 3) {
					 	include('add_brukere.php');
					}
				if(isset($_GET['updateusererror'])) {
					echo "Det oppstod en feil ved oppdatering av brukeren";
				} elseif(isset($_GET['posterror']))  {
					echo "Det oppstod en feil ved lagring av brukeren, prøv på nytt";
				}
				if(isset($_GET['deleted'])) {
								echo "<span>//Brukeren ble slettet!</span>";
							} elseif(isset($_GET['deleteerr'])) {
									echo "<span>//Det oppstod en feil ved sletting av denne brukeren</span>";
								}
					if(!count(sjekkAntall('brukere'))) {
						echo "<center><legend>Ingen registrerte brukere</legend></center>"; 
						} else { 

							?>
						<?php 
						//inkluderer liste over brukere
						include 'form.php'; }?>
				</section>	
       		</div>
       		<?php 	include('design/footer.php'); ?>
		</body>
</html>