<!--Denne siden er utviklet av  Erik Bjørnflaten (html\css) og Kurt A. Aamodt (php)., siste gang endret 14.05.2014
Denne siden er kontrollert av Dag-Roger Eriksen siste gang 29.05.2014 !-->
<?php include_once 'includes/init.php';
protected_page();
$db = getDB();

$bPK = $user_data['brukerPK'];


//Oppdaterer brukerens informasjon på minside
if(!empty($_POST['updateinfo'])) {
  if (isset($_POST['password']) === true && isset($_POST['oldpassword']) === true && empty($_POST['passwordcheck']) === false) {
    if(strlen($_POST['password']) >= 8) {
      $gammeltpw = passord(sanitize($_POST['oldpassword']));
      $nyttpassord = passord(sanitize($_POST['password']));

    if($user_data['passord'] != $gammeltpw) {
        $errors[] = 'Gammelt passord stemmer ikke';
    } else if($_POST['password'] === $_POST['passwordcheck']) {
                $epost = $user_data['ePost'];
                endrePW($nyttpassord, $epost);
                } else {
                      $errors[] = 'De nye passordene er ikke like';
                    }
    } else {
        $errors[] = 'Passordet er for kort, minst 8 tegn';
          } 
  }

  //Sjekker at feltene er satt og at epost ikke finnes fra før
  if(isset($_POST['upfnavn'],$_POST['upenavn'], $_POST['upepost'])) {
    if($user_data['ePost'] == $_POST['upepost'] ||  $user_data['ePost'] != $_POST['upepost'] && user_exists($_POST['upepost']) == false) {
    $brukerPK = $user_data['brukerPK'];
    $fnavn = sanitize(trim($_POST['upfnavn']));
    $enavn = sanitize(trim($_POST['upenavn']));
    $epost = sanitize(trim($_POST['upepost']));


      //Sjekker om fornavn, etternavn eller epost i inputfeltet er forskjellig fra det brukeren har etter innlogging, dersom det er forskjellig settes en variabel for oppdateringen
      if($user_data['fornavn'] != $fnavn || $user_data['etternavn'] != $enavn || $user_data['ePost'] != $epost ) {
          if($user_data['fornavn'] != $fnavn && $user_data['ePost'] != $epost || $user_data['etternavn'] != $enavn && $user_data['ePost'] != $epost) {
            $oldnavnogepost = $user_data['fornavn']." ".$user_data['etternavn']." bytta navn til ".$fnavn." ".$enavn. " og bytta epost til ".$epost;
          } else { $oldnavnogepost = ""; }
           if($user_data['fornavn'] != $fnavn && $user_data['ePost'] == $epost || $user_data['etternavn'] != $enavn && $user_data['ePost'] == $epost) {
            $oldnavn = $user_data['fornavn']." ".$user_data['etternavn']." bytta navn til ".$fnavn." ".$enavn;
          } else { $oldnavn = ""; }
          if($user_data['ePost'] != $epost && $user_data['fornavn'] == $fnavn && $user_data['etternavn'] == $enavn) {
            $oldepost = $user_data['fornavn']." ".$user_data['etternavn']." bytta epost til ".$epost;
          } else { $oldepost = ""; }

      $nyinfo = $oldnavnogepost." ". $oldnavn." ".$oldepost;
      $dato = date("Y-m-d H:i:s");


      //Sjekker i txtfila om brukeren har endra info før, og sletter eventuelt den gamle informasjonen, før den nye legges til.
      $mytxt = new MyTXT("userinfo.txt");
      $i=-1;
      $index = "";
        foreach ($mytxt->rows as $row) {
          $i++;
          if ($row['brukerPK'] == $bPK) {
           $index = $i;
             $mytxt->remove_row($index);
          }
        }

        //Legger til informasjon om den nye endringen for brukeren i txtfilen
        $mytxt->add_row(array($bPK, $nyinfo, $dato));
        $mytxt->save("userinfo.txt");
        $mytxt->close();
      }


      if(!empty($fnavn) && !empty($enavn) && !empty($epost)) {  
      if(empty($errors) === true) {   
          if(endreBrukerInfo($brukerPK, $fnavn, $enavn, $epost)) {
             header('Location: profil.php?oppdatert');
          } else { $errors[] = "Noe gikk galt, fikk ikke oppdatert informasjonen til databasen"; }
        }
      } else { $errors[] = "Navn og epost kan ikke være tomme"; }
    } else { $errors[] = "Eposten er allerede i bruk"; }
  }
}

?>
<!--
******************************************************************************************************************************/
**************Dette er "profilsiden" for alle brukere, her kan man endre brukerinformasjon og passord************************/
*****************************************************************************************************************************/
 -->   
<!doctype html>
<html>
<?php 
    $pgName = 'Min profil';
    include 'design/head.php'; ?>
    <body onunload="unloadP('profil')" onload="loadP('profil')" id="profil">
        <?php include 'design/header.php'; ?>
        <style type="text/css">
/*For div med profilinformasjon*/
.profilinformasjon{
  height:auto;  
  margin-left: 27% ;
  margin-right: auto ;
  width:30%;
  margin-top:2%;
}

/*Labels*/
.proinf{
  width:40%;
  margin-right:1%;
  margin-left:1%;
  display:inline-block;
  text-align: right;
}

/*Header h3*/
.proinffo {
text-align: center;
}

/*Oppdater knapp*/
#updt {
margin-top:5%;
margin-left: 43% ;
}



/*Oppdatert melding*/
#mld {
 margin-left: 43%;
}

        </style>
          <!--Elemeneter for å oppdatere brukerens profil!-->
        <div id="page">
          <section>
            <div class="profilinformasjon">
            <h3 class="proinffo">Profil informasjon</h3><br>
               <form name="profil" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                  <label class="proinf">Fornavn:</label><input type="text" name="upfnavn" class="minsideinput" value="<?php echo $user_data['fornavn'] ?>"/><br><br>
                  <label class="proinf">Etternavn:</label><input type="text" name="upenavn" class="minsideinput"  value="<?php echo $user_data['etternavn'] ?>"/><br><br>
                  <label class="proinf">E-post:</label><input type="text" name="upepost" class="minsideinput" value="<?php echo $user_data['ePost'] ?>"/><br><br><br>
                  <label class="proinf">Nåværende passord:</label><input type="password" name="oldpassword" class="minsideinput"  placeholder="Gammelt passord"/><br><br>
                  <label class="proinf">Nytt passord:</label><input type="password" name="password" class="minsideinput" placeholder="8 tegn eller flere"/><br><br>
                  <label class="proinf">Bekreft passordet:</label><input type="password" name="passwordcheck" class="minsideinput" placeholder="Bekreft nytt passord" />             
                  <input type='submit' class="buttonStyle" id="updt" name="updateinfo" value="Oppdater"/><br />
                </form>
                <div id='mld'>
              <?php 
                    //Skriver ut statusmeldiner i forbindelse med profiloppdatering
                    if(isset($_GET['oppdatert'])) {
                      echo "<p class='okmsgcolor'>Oppdatert</p>";
                    }
                    if (empty($errors) === false) {
                        echo "<span class='errormsgcolor'>";
                        echo output_errors($errors);
                        echo "</span>";
                    } ?>
              </div>
            </div> <!--Slutt på div for profilinformasjon-->
            <br class="clear" />
          </section>
        </div>
        <?php include('design/footer.php');  ?>
    </body>
</html>

