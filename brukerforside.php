<!--Denne siden er utviklet av Erik Bjørnflaten og Dag-Roger Eriksen, siste gang endret 03.03.2014
Denne siden er kontrollert av Kurt A. Aamodt siste gang 03.03.2014 !-->
<?php include 'includes/init.php';
$db = getDB();
?>

<!doctype html>
<html>
<?php
    $pgName = 'Startside for deltakere';
    include 'design/head.php'; ?>
<body>
	<div id="page">
	<?php include 'design/header.php'; ?>
		<section>
		<!-- Brukerforside main venstre !-->
			<div id="bfvenstre">
			<center><legend><h4>Ubesvarte oppgaver</h4></legend></center>
			<?php include'ubesvartliste.php'; ?>
			</div>
		<!-- Brukerforside main hoyre !-->
			<div id="bfhoyre">
			<center><legend><h4>Besvarte oppgaver</h4></legend></center>
			<?php include'besvart.php'; ?>
			</div>
		</section>
	<?php include('design/footer.php'); ?>
	</div>

</body>
</html>