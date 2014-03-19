<!--Denne siden er utviklet av Erik Bjørnflaten, siste gang endret 03.03.2014
Denne siden er kontrollert av Kurt A. Aamodt siste gang 03.03.2014  !-->
<?php 
include_once 'includes/init.php';

?>

<!DOCTYPE html>
<html lang="nb-no">
		<?php
		include('design/head.php');
		?>
		<body onload="fjernType(<?php echo $user_data['brukertype']; ?>, 'nytype');" >
			<div id="page">
				<?php
				include('design/header.php');
				?>
		        <section style="width:94%">
		       	<?php
		       	if($user_data['brukertype'] != 3) {
					 	include('add_brukere.php');
					}		      
					if(!count(sjekkRegbrukere())) {
						echo 'Ingen registrerte brukere'; 
						} else { ?>
					<center><legend>Liste over brukere</legend></center><br>
						<?php include 'form.php'; }?>
				</section>
	    		<?php include('design/footer.php'); ?>
       		</div>
		</body>
</html>