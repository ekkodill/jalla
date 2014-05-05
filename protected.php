<!--Denne siden er utviklet av Kurt A. Aamodt, siste gang endret 03.03.2014
Denne siden er kontrollert av Erik Bjørnflaten siste gang 03.03.2014  !-->

<?php 
include_once 'includes/init.php'; ?>

 <!--************************************************************************************************-->
 <!--Denne siden er for å stoppe brukere som ikke er innlogget i å få tilgang til sider de ikke skal-->
 <!--************************************************************************************************-->

<!doctype html>
<html>
    <?php 
	$pgName = 'Forbudt område';
    include 'design/head.php'; ?>
<body>
<?php include 'design/header.php'; ?>
<div id="page">
  
  <h1>Beklager, du må være innlogget for å se denne siden.</h1> 
    <p>Send epost for forespørsel om registrering eller logg inn.</p>
<?php include('design/footer.php'); ?>
</div>
</body>
</html>
