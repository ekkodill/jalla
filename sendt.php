<!--Denne siden er utviklet av Dag-Roger Eriksen., siste gang endret 27.03.2014
Denne siden er kontrollert av Kurt A. Aamodt siste gang 30.03.2014  !-->

<?php include_once 'includes/init.php';
logged_in_redirect(); //Forhindrer innloggede brukere å gå manuelt til denne siden.
 ?>
 <!--**************************************************************-->
 <!--Denne siden er for å gi beskjed om at nytt passord er på vei-->
 <!--**************************************************************-->
<!doctype html>
<html>
<?php 
$pgName = 'Nytt passord';
include 'design/head.php'; ?>
<body onLoad="loadPage()">
<?php include 'design/header.php' ?> 
	<div id="page">
		  
			<section>
	        	<div class="midtfeltpw"> 
					<h2>Nytt passord</h2> 
					<p>Nytt passord er sendt til følgene e-post adresse: <b><?php echo $_SESSION['recover'];?></b> </p> 
					<p>Husk å sjekke søppelpost mappen. Hvis du ikke har fått en e-post i løpet av 5 minutter, si fra til oss.</p>
					</br>
					<p><a href="logout.php"><b>Trykk her</b></a> for å gå tilbake til startsiden.</p>
	         	</div>
	        </section> 
		<?php include 'design/footer.php' ?>
	</div>
</body>
</html>