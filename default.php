<!--Denne siden er utviklet av Erik Bjørnflaten og Dag-Roger Eriksen, siste gang endret 03.03.2014
Denne siden er kontrollert av Kurt A. Aamodt siste gang 03.03.2014  !-->
<?php include 'includes/init.php'; 
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
          <div class="midtfelt">
            <h2>Velkommen til Touch</h2> 
            <img class="bilde"src="img/keyboard.jpg" height="300" alt="Bli kjappere på tastene." position="fixed">
            <p>I denne applikasjonen skal vi trene deg opp i øke hastigheten når du skriver på tastaturet.</p>
            <p>Det vil i nær fremtid bli lagt ut prøvetekster, der vi tar tiden på deg fra start til slutt. Tidene vil bli lagret og du kan se fremgangen din på "Min side" når du får tilgang til den.</p><p>Grunnen stor etterspørsel har vi nå valgt å fjerne valget om å registrere seg. Man må nå bli lagt inn av en administrator eller veileder.
            <p>Registreringen vil bli åpnet igjen om ikke så alt for lenge så titt innom i ny og ne.</p>
            <h3>Bli kjappere på tastene idag!</h3>
          </div> 

          <?php   if(logged_in() === false) {include 'includes/loginbox.php';} ?>

        </section>
      <?php include('design/footer.php'); ?>
    
  </body>
</html>
