<!--Denne siden er utviklet av Kurt A. Aamodt (PHP og JS) og Erik Bjørnflaten (HTML)., siste gang endret 04.05.2014
Denne siden er kontrollert av Mikael kolstad siste gang 04.05.2014 !-->
<?php
include_once 'includes/init.php';
protected_page();
$pgName = 'Skrivesenter';

//Resetter variablene når siden lastes på nytt
$otittel = "";
$otekst = "";
$lagrettext = "";

//Setter verdiene fra session variablene til lokale variabler som vises på siden
if(isset($_SESSION['tid']) && isset($_SESSION['antfeil']) && isset($_SESSION['percent'])) {
    $otid = $_SESSION['tid'];
    $ofeil = $_SESSION['antfeil'];
    $oprosent = $_SESSION['percent'];
} else {
    $otid = 0;
    $ofeil = 0;
    $oprosent = 0;
}

//Initierer session varibaler for å holde på data som skal brukes ved lagring\innlevering av tidligere lagra oppgaver.
if (!empty($_POST)) {
    if(!empty($_POST['tittel']) && !empty($_POST['oppgtxt']) && !empty($_POST['oppgPK'])) {
    $otittel = $_POST['tittel'];
    $otekst = strip_tags($_POST['oppgtxt']);
    $_SESSION['otittel'] = $otittel;
    $_SESSION['oppgtxt'] = $otekst;
    $_SESSION['oppgPK'] = $_POST['oppgPK'];
    $_SESSION['innlPK'] = $_POST['innPK'];
    $_SESSION['gammelTid'] = $_POST['gammelTid'];
    $lagrettext = $_POST['lagrettext'];
    $_SESSION['tid'] = 0;
    $_SESSION['antfeil'] = 0;
    $_SESSION['percent'] = 0;
    $otid = 0;
    $ofeil = 0;
    $oprosent = 0;
    }
} else {
$otittel = "";
$otekst = "";
//$lagrettext = "";
}


//Setter nedtrekksmenyen til riktig valg når siden lastes på nytt.
 if(!empty($_POST['oppgliste'])) {
         $_SESSION['drpdwnlist'] = $_POST['oppgliste'];
     } else {
         if(isset($_SESSION['drpdwnlist'])) {
            $_SESSION['drpdwnlist'] =  $_SESSION['drpdwnlist'];
        } else {
            $_SESSION['drpdwnlist'] = 'ubesvoppg';
        }
     }

//Cookie for scrollposisjon
if(!empty($_COOKIE["y"])) {
$y = $_COOKIE["y"];
} else { $y = 0; }


?>

<!--*******************************************************************-->
<!--**********Denne siden er for å utføre oppgaver*********************-->
<!--*******************************************************************-->

<!doctype html>
<html>
<?php
$pgName = 'Skrivesenter';
include_once 'design/head.php';
?>
<script type="text/javascript" src='js/tastatur.js'></script>
<script type="text/javascript"  src='js/stoppeklokke.js'></script>
<script type="text/javascript"  src='js/compareStrings.js'></script>

<?php
print "<body id='skriv' onScroll=\"document.cookie='y=' + window.pageYOffset\" onLoad='window.scrollTo(0,$y); show(); loadStyle();'>";
 include_once 'design/header.php'; 
?>
    <div id="page">
    <section> 
        <div class="bfleft">
        <!--Elementer på venstre side som viser tid brukt, antall feil og feilprosent når man lagrer\leverer oppgaven-->
            <div class="valgmuligheter">             
                    <input type="button" class="stopkn" value="stop" onclick="stop();">
                    <input type="button" class="resetkn" value="reset" onclick="reset();">
                    <p>
                    <?php 
                        echo "Tid brukt: ".$otid;
                        echo "<br>Antall feil: ".$ofeil. "<br> Prosent rett: ".$oprosent."%";
                     ?>
                     </p>
                    <form action="add_besvarelse.php" method="POST">
                      <h5>Tid brukt</h5>
                      <div><span name="tid" id="time"></span></div>
                    
                        <input type="button" class="visskjul" onclick="setStyle('container');" value="Trykk"/> for å skjule\vise tastaturet
                    <br>
                        <input name="fullfor" id="innlevering" class="innleverop" type="submit" onclick="transfer();stop();" value="Innlever"/> for endelig innlevering
                    <br>
                        <input name="lagreoppg" id="lagring" class="lagropg" type="submit" onclick="transfer();stop();" value="Lagre"/> for å fortsette senere
                        <input name="tid" id="stid" type="hidden"/>
                        <input name="jsfeil" id="jsfeil" type="hidden"/>
                    <br>
                    <br>
                        <?php 

                        //Statusmeldinger om oppgaven blir lagret/levert eller det oppstår feil.
                        if(isset($_GET['lagret'])) {
                            echo "Lagret oppgaven";
                            } elseif(isset($_GET['innlevert'])) {
                                echo "Oppgaven ble levert.";
                            } elseif(isset($_GET['error'])) {
                                echo "Det oppstod en feil. Kunne ikke lagre.";
                            }
                             ?>           
            </div>
        </div>
            <div class="bfright">
            <!--Høyres side med elementer som viser oppgavetittel og oppgaveteksten-->
                <div class="oppgavetittel"><?php echo $otittel; ?></div>
                <div class="fasit"><?php echo $otekst; ?></div>
                <input id="fasittekst" type="text" hidden value="<?php echo $otekst; ?>" />
            </div>
            <!--Midtseksjon med textarea for å utføre oppgaven-->
                <div class="opgtextramme">
                        <textarea name='inntext' id='opgtekst' onfocus='start();' onblur='stop();'><?php echo $lagrettext  ?></textarea>
                    </form>
                </div>
            <div class="uboliste2">
            <!--Venstre side med elementer for oppgavelisten, søkeboks og nedtrekksmeny for valg av liste-->
                <center><legend class="ubotitt"><h4>Ubesvarte oppgaver</h4></legend></center>
                <form action="skriv.php" id="velgli" method="post">
                    <select id='sel' name='oppgliste' class="dropned" onchange="this.form.submit();">
                        <option name="ubesvoppg"     value='ubesvoppg' <?php if($_SESSION['drpdwnlist'] == 'ubesvoppg') {echo "selected";}?>>Ubesvarte oppgaver</option>
                        <option name="pbegoppg" value='pbegoppg' <?php if($_SESSION['drpdwnlist'] == 'pbegoppg') {echo "selected";}?>>Påbegynte oppgaver</option>
                    </select> <input type="text" id="search" placeholder="  Søk"></input>

                </center>
                </form>
               
                <div style="height: 100%; overflow: auto;">
        <table class="ubesform">         
            <tbody>
                <?php 
                //Inkludrer riktig liste med ubesvarte\påbegynte oppgaver for riktig bruker
                $bPK = $user_data['brukerPK'];
                if(!empty($_SESSION['drpdwnlist'])) {
                    if($_SESSION['drpdwnlist'] == 'ubesvoppg') {
                      $result = ubesvarteOppg($bPK, 3);
                    } elseif( $_SESSION['drpdwnlist'] =='pbegoppg') {
                      $result = ubesvarteOppg($bPK, 0);
                    } 
                }else {
                        $result = ubesvarteOppg($bPK, 3);
                    }

                include_once 'ubesvartliste.php'; ?> 
            <tbody>
           
        </table>
         </div>
            </div>
        <!--Tastaturet-->
            <div id="container">
                    <ul id="keyboard">
                        <img src="img/capsoff.png"  alt="capslock er av" id="capslockoff" class="caps">
                        <img  hidden src="img/capson.png" width="12.5" height="12.5" alt="capslock er på" id="capslock" class="caps">
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
                        <li class="tab"id="tabb">&LeftArrowRightArrow;</li>
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
                <br class="clear" />
            </section>
        <?php include_once('design/footer.php'); ?>
        </div>
    </body>
</html>
