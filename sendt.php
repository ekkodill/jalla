<!--Denne siden er utviklet av Dag-Roger Eriksen., siste gang endret 03.03.2014
Denne siden er kontrollert av Kurt A. Aamodt siste gang 03.03.2014  !-->

<?php include_once 'includes/init.php'; ?>


<!doctype html>
<html>
<?php include 'design/head.php'; ?>
	<body onLoad="loadPage()">
		<div id="page">
<?php include 'design/header2.php' ?>   
		<section style="width:94%">
        	<div class="midtfeltpw"> 
				<h2>Nytt passord</h2> 
				<p>Nytt passord er sendt til følgene e-post adresse: <b><?php echo $_SESSION['recover'];?></b> </p> 
				<p>Husk å sjekke søppelpost mappen. Hvis du ikke har fått en e-post i løpet av 5 minutter, si fra til oss.</p>
			</br>
				<p><a href="logout.php">Trykk her</a> for å gå tilbake til startsiden.</p>
         	</div>
         </section> 
<?php include 'design/footer.php' ?>
    </body>
</html>