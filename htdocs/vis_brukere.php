<!--Denne siden er utviklet av Erik Bjørnflaten, siste gang endret 03.03.2014
Denne siden er kontrollert av Kurt A. Aamodt siste gang 03.03.2014  !-->
<?php 
include_once 'includes/init.php';
$db = getDB();
include 'nybruker.php';
?>

<!DOCTYPE html>
<html lang="nb-no">
		<?php
		include('design/head.php');
		?>
	<body>
		<div id="page">
		<?php
		include('design/header.php');
		?>
        <section style="width:94%">
       	<?php
			if(!count($resultat)) {
				echo 'Ingen registrerte brukere'; 
			} else { 
		?>
		<center><legend>Legg til bruker  <?php print_r(logged_in());?></legend></center><br>
		<div class="leggtilbruker"><br>
		<form action="nybruker.php" method="post" id="nybruker">
			<table>
				<tr>
					<th class="tab1">Epost</th>
					<th class="tab1">Etternavn</th>
					<th class="tab1">Fornavn</th>
					<th class="tab1">Brukertype</th>
				</tr>
				<tr>
					<td><input class="tarea" type="text" name="ePost" id="ePost" autocomplete="off"></td>
					<td><input class="tarea" type="text" name="etternavn" id="etternavn" autocomplete="off"></td>
					<td><input class="tarea" type="text" name="fornavn" id="fornavn" autocomplete="off"></td>
					<td><input class="tarea" type="text" name="brukertype" id="nybrukertype" autocomplete="off"></td>
				</tr>
			</table>
			<h7 class="paakrev">*Må fylles inn.</h7><br>
			<center><input class"leggtilny" type="submit" value="Legg til ny bruker" onclick="return regNy();"></center>
		
	</form>
    </div>
		<br>
			<br>
			<br>
		<br>
		<center><legend>Liste over brukere</legend></center><br>
		<?php include 'form.php';
		}
		?>
	</section>
    	<?php include('design/footer.php'); ?>
        
	</body>
</html>