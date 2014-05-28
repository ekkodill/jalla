<!--Denne siden er utviklet av Mikael og Erik., siste gang endret 03.03.2014
Denne siden er kontrollert av Kurt A. Amodt siste gang 03.03.2014 !-->
<!doctype html>
<html>
    <?php include 'design/head.php'; ?>
<body>
<div id="page">
  <?php include 'design/header.php'; ?>
<section style="width:94%"> 
    <div id="minside">
            <aside>
                <div id="hide">
                    <form id="byttpw" name="reg">
                     <h2>Bytt passord</h2>
                        Gammelt passord: 
                        <br><input type="password" id="gammelt" name="oldpassword" placeholder="Gammelt passord"><br>
                        Nytt passord: 
                        <br><input type="password" id="nytt" name="password" placeholder="8 tegn eller flere"><br>
                        Bekreft nytt passord: 
                        <br><input type="password" id="bekreft" name="passwordcheck" placeholder="Bekreft nytt passord"><br>
                        <input type="Submit" id="pwknapp" onclick="return passwordCheck()" value="Bekreft">
                    </form>
                 </div>
            </aside>
            
        </section>
        <?php include('design/footer.php'); ?>
    
   
</body>
</html>
