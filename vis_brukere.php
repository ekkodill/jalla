<!--Denne siden er utviklet av Erik Bjørnflaten, siste gang endret 30.03.2014
Denne siden er kontrollert av Kurt A. Aamodt siste gang 30.03.2014  !-->
<?php 
include_once 'includes/init.php';
$db = getDB(); //Tilkobling til databasen.

?>

<!DOCTYPE html>
<html lang="nb-no">
		<?php
		$pgName = 'Vis brukere';
		include('design/head.php');
		include('design/footer.php'); ?>
			<body onload='fjernType(<?php echo $user_data['brukertype']; ?>, "nytype");loadP("visbrukere");' onunload='unloadP("visbrukere")'>
			<?php include('design/header.php');	?>
<script type="text/javascript">
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

//Lagrer nedtrekksmenyen verdi til localStorage
$(document).ready(function(){
    $('#nytype').change(function(){
         localStorage.setItem('btype', $(this).val());
         $('#nytype').value(localStorage.getItem('btype'));
    });
})

});

</script>
			<div id="page">
			   <section>
		       	<?php
		       	if($user_data['brukertype'] != 3) {
					 	include('add_brukere.php');
					}	      
					if(!count(sjekkAntall('brukere'))) {
						echo "<center><legend>Ingen registrerte brukere</legend></center>"; 
						} else { 
							if(!empty($_SESSION['delerr'])) {
								echo "<span>//".$_SESSION['delerr']."</span>";
								$_SESSION['delerr'] = "";
							}
							?>
					<center><legend><h4>Liste over brukere</h4></legend></center>
						<?php include 'form.php'; }?>
				</section>	
       		</div>
		</body>
</html>