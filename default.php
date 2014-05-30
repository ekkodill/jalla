<!--Denne siden er utviklet av Erik Bjørnflaten og Dag-Roger Eriksen, siste gang endret 03.03.2014
Denne siden er kontrollert av Kurt A. Aamodt siste gang 03.03.2014  !-->
<?php include 'includes/init.php'; ?>

<!doctype html>
<html>
<?php   
$pgName = 'Hovedside';
include 'design/head.php';
 ?>
 <style type="text/css">

/*Sjekkmerke og styling for systemkravene*/
.midtfelt li { 
    background: white url(img/check.png) no-repeat 0 100%; 
    padding-left: 30px;
    list-style-position:inside;
    list-style-type: none;
 }
.midtfelt ul {
    margin-top:5px;
    padding:0;
 }



/***************************/

/*Plassering av bildet*/
 .bilde {
    padding-right: 10%;
 }
 </style>
<body onunload="unloadP('hovedside');" onload="loadP('hovedside');">
<?php  include 'design/header.php';  ?>
        <section>
          <div class="midtfelt">
            <h2>Velkommen til Touch</h2> 
            <div class="bilde"><img class="bilde"src="img/keyboard.jpg" height="250"  alt="Bli kjappere på tastene." ></div>
            <p>I denne applikasjonen skal vi trene deg opp i øke hastigheten når du skriver på tastaturet.<br>
            Registrer deg i dag å få nye oppgaver og øve deg på, med respons fra egne veiledere.</p>
            <p> Den optimale måten å lære seg touchmetoden.</p>
            <h3>Bli kjappere på tastene idag!</h3>
            <br>

            <h5><i><b>Systemkrav:</b></i></h5>
            <p>For optimal brukeropplevelse kreves følgende utstyr og programvare:</p>
            Nettlesere:
            <ul>
                <li>Firefox</li>
                <li>Chrome</li>
                <li>IE</li>
            </ul>
            Script:
            <ul>
                <li>Javascript</li>
            </ul>
            Skjermoppløsning:
           <ul>
               <li>1920x1080</li>
           </ul>
           <br>
          </div> 
          
        </section>
    <?php include('design/footer.php'); ?>
  </body>
</html>
