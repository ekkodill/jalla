<!--Denne siden er utviklet av Erik Bjørnflaten., siste gang endret 13.04.2014
Denne siden er kontrollert av kurt siste gang 03.03.2014 !-->
<?php
include_once 'includes/init.php';

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
<body>
<div id="page">
<?php include_once 'design/header.php'; ?>
<section style="width:94%">

<div class="bfleft">
<div class="valgmuligheter">Valgmuligheter</div>
</div>


<div class="bfright">
<div class="oppgavetittel">Tittel på oppgaven</div>
<div class="fasit">fasit</div>
</div>

<div class="opgtextramme"><textarea id="opgtekst" onfocus="this.style.background='#f2f2f2'" onblur="this.style.background='url(http://blog.lantrax.com/Portals/143289/images/stopwatch-resized-600.jpg) '"></textarea></div>

<div class="uboliste"></div>


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
</div>
</body>
</html>