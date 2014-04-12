<!--Denne siden er utviklet av Erik Bjørnflaten og Dag-Roger Eriksen, siste gang endret 03.03.2014
Denne siden er kontrollert av Kurt A. Aamodt siste gang 03.03.2014  !-->
<?php include 'includes/init.php'; 
$db = getDB();
?>

<!doctype html>
<html>
    <?php
    $pgName = 'Hovedside';
    include 'design/head.php'; ?>
  <body>
    <div id="page">
      <?php include 'design/header.php';  ?>      
        <section>
        <!-- Brukerforside main venstre !-->
     <div id="bfvenstre">
      <?php include'oppgaveliste.php'; ?>
     </div>

     <!-- Brukerforside main hoyre !-->
     <div id="bfhoyre">
<?php include'ubesvart.php'; ?>
     </div>
          <?php   if(logged_in() === false) {include 'includes/loginbox.php';} ?>

        </section>
      <?php include('design/footer.php'); ?>
    </div>
  </body>
</html>
