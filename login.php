<!--Denne siden er utviklet av Kurt A. Aamodt og Dag-Roger Eriksen, siste gang endret 27.03.2014
Denne siden er kontrollert av Kurt A. Aamodt? siste gang 03.03.2014  !-->

<?php
include 'includes/init.php';
//Sjekker at login er submitta
if(empty($_POST) === false) {
	$brukernavn = $_POST['brukernavn'];
	$passord 	= $_POST['passord'];

//Sjekker at brukernavn og passord feltet inneholder noe og sjekker at informasjonen er gyldig.
if (empty($brukernavn) === true || empty($passord) === true) {
		$errors[] = 'Du må skrive inn brukernavn og passord.';
	} else if (user_exists($brukernavn) === false) {
		$errors[] = 'Vi kan ikke finne dette brukernavnet.'.$brukernavn;
	} else {
		if (strlen($passord) > 32) {
			$errors[] = 'Passordet kan ikke være lengre enn 32 tegn';
		}
		$login = login($brukernavn, $passord);
		if ($login === false) {
			$errors[] = "Feil brukernavn eller passord";
		} else {
			$_SESSION['brukerPK'] = $login;
			header('Location: default.php');
			exit();
		}
	}
}  else {
	header('location: default.php');
}

?>

<!doctype html>
<html>
    <?php 
    $pgName = 'Innlogging';
    include 'design/head.php'; ?>
  	<body>
		<div id="page">
		    <?php include 'design/header.php'; ?>
		    	<section>
		      		<div class="midtfelt">
						<?php
							if (empty($errors) === false) {
							?><h2>Vi prøvde og logge deg inn men...</h2><?php
							echo output_errors($errors);
							}?>
					</div>
						
		  				<?php include ('includes/loginbox.php');?>
					
				</section>
			<?php include('design/footer.php'); ?>
		</div>
	</body>
</html>



