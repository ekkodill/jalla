<!--Denne siden er utviklet av Erik Bjørnflaten., siste gang endret 13.04.2014
Denne siden er kontrollert av kurt siste gang 03.03.2014 !-->
<?php
include_once 'includes/init.php';

$pgName = 'Touch-tastatur';
$otittel ="";
$otekst = "";
$oppgPK = "";
$tid = 0;
//Sjekker om det kommer fra deltakernsstartside med oppgavetekst og tittel



if (!empty($_POST)) {
   if(isset($_POST['lagreoppg'])) {
    $tid = $_POST['tid'];
}
    if(!empty($_POST['tittel']) && !empty($_POST['oppgtxt']) && !empty($_POST['oppgPK'])) {
        $otittel = $_POST['tittel'];
        $otekst = $_POST['oppgtxt'];
        $oppgPK = $_POST['oppgPK'];
    }
}

?>
<!doctype html>
<html>
<style type="text/css">
 <!-- 
  #opgtekst {
 background: url(http://blog.lantrax.com/Portals/143289/images/stopwatch-resized-600.jpg);
 background-position: center;
  }
 -->
 </style>
<?php
$pgName = 'Touch-tastatur';
include_once 'design/head.php'; ?>
<script type="text/javascript" src='js/tastatur.js'></script>

<body onload="show();">
    <div id="page">
  <?php include_once 'design/header.php'; ?>
    <section style="width:94%"> 
    
        <div class="bfleft">
            <div class="valgmuligheter">             
                    <input type="button" value="start" onclick="start();">
                    <input type="button" value="stop" onclick="stop();">
                    <input type="button" value="reset" onclick="reset()">
                    <p>
                    <?php 
                        echo "tid brukt: ".$tid;
                     ?>
                     </p>
                    <form action="skriv.php" method="POST">
                      <h5>Tid brukt</h5>
                      <div><span name="tid" id="time"></span></div>
                    <br>
                        <input type="button" onclick="toggle_div('container');" value="Klikk her"/> for å skjule \ vise tastaturet
                    <br>
                        <input name="fullfor" type="submit" onclick="" value="Innlever"/> for endelig innlevering
                    <br>
                        <input name="lagreoppg" type="submit" onclick="transfer();" value="Lagre"/> for å fortsette senere
                        <input name="tid" id="stid" type="hidden" value=""/>
            </div>
            <div class="uboliste">
                <legend class="ubotitt"><h4>Ubesvarte oppgaver</h4></legend>
                <?php include_once 'ubesvartliste.php'; ?> 
            </div>
       </form></div>
           
   <div class="bfright">
                <div class="oppgavetittel"><?php echo $otittel; ?></div>
                <div class="fasit"><?php echo $otekst;  ?></div>
            </div>
            
                <div class="opgtextramme"><textarea id="opgtekst" onfocus="this.style.background='#f2f2f2'" onblur="this.style.background='url(http://blog.lantrax.com/Portals/143289/images/stopwatch-resized-600.jpg) '"></textarea></div>

<div id="container">
<ul id="keyboard">
<li class="capsen lastitem"><br><img src="img/capsoff.png" width="12.5" height="12.5" alt="capslock er av"></li>
<li hidden class="caps"id="capslock"><img src="img/capson.png" width="12.5" height="12.5" alt="capslock er på"></li>
<br>
<li class="tegn"id="220"><span class="off">|</span><span class="on">§</span></li>
<li class="tegn"id="49"><span class="off">1</span><span class="on">!</span></li>
<li class="tegn"id="50"><span class="off">2</span><span class="on">"</span></li>
<li class="tegn"id="51"><span class="off">3</span><span class="on">#</span></li>
<li class="tegn"id="52"><span class="off">4</span><span class="on">¤</span></li>
<li class="tegn"id="53"><span class="off">5</span><span class="on">%</span></li>
<li class="tegn"id="54"><span class="off">6</span><span class="on">&</span></li>
<li class="tegn"id="55"><span class="off">7</span><span class="on">/</span></li>
<li class="tegn"id="56"><span class="off">8</span><span class="on">(</span></li>
<li class="tegn"id="57"><span class="off">9</span><span class="on">)</span></li>
<li class="tegn"id="48"><span class="off">0</span><span class="on">=</span></li>
<li class="tegn"id="187"><span class="off">?</span><span class="on">+</span></li>
<li class="tegn"id="219"><span class="off">\</span><span class="on">`</span></li>
<li class="delete lastitem"id="8">&larr;</li>
<li class="tab"id="9">&LeftArrowRightArrow;</li>
<li class="tegn" id="81">Q</li>
<li class="tegn"id="87">W</li>
<li class="tegn"id="69">E</li>
<li class="tegn"id="82">R</li>
<li class="tegn"id="84">T</li>
<li class="tegn"id="89">Y</li>
<li class="tegn"id="85">U</li>
<li class="tegn"id="73">I</li>
<li class="tegn"id="79">O</li>
<li class="tegn"id="80">P</li>
<li class="tegn"id="221">Å</li>
<li class="tegn"id="186"><span class="off">¨</span><span class="on">^</span></li>
<li class="xreturn"id="entr"></li>
<li class="white"id="dot">&crarr;</li>
<li class="capslock"id="20">capslock</li>
<li class="tegn"id="65">A</li>
<li class="tegn"id="83">B</li>
<li class="tegn"id="68">D</li>
<li class="tegn"id="70"><span class="off">F</span><span class="on2">_</span></li>
<li class="tegn"id="71">G</li>
<li class="tegn"id="72">H</li>
<li class="tegn"id="74"><span class="off">J</span><span class="on2">_</span></li>
<li class="tegn"id="75">K</li>
<li class="tegn"id="76">L</li>
<li class="tegn"id="192">Ø</li>
<li class="tegn"id="222">Æ</li>
<li class="tegn"id="191"><span class="off">'</span><span class="on">*</span></li>
<li class="return" id="enter"> </li>
<li class="left-shift" id="lshift">&uarr;</li>
<li class="tegn"id="60"><span class="off"><</span><span class="on">></span></li>
<li class="tegn"id="90">Z</li>
<li class="tegn"id="88">X</li>
<li class="tegn"id="67">C</li>
<li class="tegn"id="86">V</li>
<li class="tegn"id="66">B</li>
<li class="tegn"id="78">N</li>
<li class="tegn"id="77">M</li>
<li class="tegn"id="188">,<span class="off">;</span><span class="on"></span></li>
<li class="tegn"id="190">.</li>
<li class="tegn"id="189"><span class="off">-</span><span class="on">_</span></li>
<li class="right-shift lastitem" id="rshift">&uarr;</li>
<li class="ctrll"id="lctrl">ctrl</li>
<li class="lalt"id="lalt">alt</li>
<li class="space lastitem" id="32"></li>
<li class="altgr"id="gralt">alt gr</li>
<li class="ctrlr"id="rctrl">ctrl</li>
</ul>
</div>
 
</section>
<?php include_once('design/footer.php'); ?>

</body>
</html>