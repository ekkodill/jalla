<!--Denne siden er utviklet av Erik Bjørnflaten, siste gang endret 30.03.2014
Denne siden er kontrollert av Kurt A. Aamodt siste gang 30.03.2014  !-->
<?php 
include_once 'includes/init.php';

?>

<!DOCTYPE html>
<html lang="nb-no">
		<?php
		$pgName = 'Vis brukere';
		include('design/head.php');
		?>
		<body onload="fjernType(<?php echo $user_data['brukertype']; ?>, 'nytype');">
			<div id="page">
				<?php
				include('design/header.php');
				?>
		        <section>
		       	<?php
		       	if($user_data['brukertype'] != 3) {
					 	include('add_brukere.php');
					}		      
					if(!count(sjekkAntall('brukere'))) {
						echo "<center><legend>Ingen registrerte brukere</legend></center>"; 
						} else { ?>
					<center><legend><h4>Liste over brukere</h4></legend></center>
						<?php include 'form.php'; }?>
				</section>
	    		<?php include('design/footer.php'); ?>
       		</div>
		</body>
</html>