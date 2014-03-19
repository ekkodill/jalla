<!--Denne siden er utviklet av Kurt A. Aamodt og Erik Bjørnflaten, siste gang endret 12.03.2014
Denne siden er kontrollert av Kurt A. Aamodt siste gang 12.03.2014  !-->

<?php
include_once 'includes/init.php';

$db = getDB();
?>
    
    <div class='bliste'><table class='tablesorter' id="tableform">
    <thead>
    <tr><th class='tab2'>Epost</th>
        <th class='tab2'>Etternavn</th>
        <th class='tab2'>Fornavn</th>
        <th class='tab2'>Brukertype</th>
        <th>
        <form method="post">
        <select id="sorter" name='sort'>
            <option name="epost"     value='ePost'     <?php if (isset($_POST['sort'])) { if($_POST['sort']=='ePost')    {echo "selected='selected'"; }} ?> >Epost</option>
            <option name="etternavn" value='etternavn' <?php if (isset($_POST['sort'])) { if($_POST['sort']=='etternavn') {echo "selected='selected'"; }} ?>>Etternavn</option>
            <option name="fornavn"   value='fornavn'   <?php if (isset($_POST['sort'])) { if($_POST['sort']=='fornavn')   {echo "selected='selected'"; }} ?>>Fornavn</option>
            <option name="brukertype"value='brukertype'<?php if (isset($_POST['sort'])) { if($_POST['sort']=='brukertype') {echo "selected='selected'"; }}?>>Brukertype</option>
        </select>
            <input type='submit' name='sorter' value="Sorter" id='sorterbtn'>
        </form></th></tr></thead><tbody id='liste'>
<?php

//Velger hva det skal sorteres på
  if (isset($_POST['sort'])) {
        $sorter = $_POST['sort'];
        switch ( $sorter ) {
                case 'ePost':
                        $sorter = "ePost ASC";
                        break;
                case 'etternavn':
                        $sorter = "etternavn ASC";
                        break;
                case 'fornavn':
                        $sorter = "fornavn ASC";
                        break;
                case 'brukertype':
                        $sorter = "brukertype ASC";
                        break;
        }
    } else {
        $sorter = "brukerPK ASC";
    }
    $result = getQuery($user_data['brukertype'], $sorter);


//Går gjennom arrayen og lager en form hvor hver rad. På denne måten kan vi slette og redigere brukere via formene.
    while ($row = $result->fetch_assoc()) {
    $PK = $row['brukerPK'];

    echo "<form action='' method='post' id='multiform'".$PK.">";
    echo "<tr>";
    echo "<td>" . "<input readonly='readonly' type='text' id='ePost".$PK."'      name='ePost'      value=" . $row['ePost']."></td>";
    echo "<td>" . "<input readonly='readonly' type='text' id='etternavn".$PK."'  name='etternavn'  value=" . $row['etternavn']."></td>";
    echo "<td>" . "<input readonly='readonly' type='text' id='fornavn".$PK."'    name='fornavn'    value=" . $row['fornavn']."></td>";
    echo "<input type='hidden' name='brukerPK' value=$PK></td>";
    echo "<td>
    <select class='tarea' name='btype' id='typer".$PK."' disabled>
    <option value='administrator'". (($row['brukertype'] == '1') ? "selected=selected'":""). ">Administrator</option>
    <option value='veileder' ". (($row['brukertype'] == '2') ? "selected=selected'":""). ">Veileder</option>
    <option value='deltaker' ". (($row['brukertype'] == '3') ? "selected=selected'":""). ">Deltaker</option>
    </select></td>"; //Nedtrekksmeny for valg av brukertype

    if($user_data['brukertype'] == 3 && $user_data['brukerPK'] == $PK || $user_data['brukertype'] != 3) {
        echo "<td><input type='image' src='img/edit.jpg' name='edit' id=$PK onclick='return onEdit(this, $user_data[brukertype], $user_data[brukerPK])'; />"; //Knapp for å redigere brukerdata
        echo "<input type='hidden'  name='lagreupdate' />";
        echo "<input type='image' hidden src='img/save.jpg' name='update' id='s".$PK."' onclick=this.form.action='update.php'; 'return onSave(this)'; />"; //Knapp for å lagre endringer
    } if($user_data['brukertype'] != 3) {
        echo "<input type='hidden' name='slett' value='$row[brukerPK]' />"; //Knapp for å slette brukere
        echo "<input type='image' id='d".$PK."' src='img/delete.jpg' name='formDelete' onclick='return slette(\"$row[fornavn]\", \"$row[etternavn]\", $PK, this, $user_data[brukertype])';   />"; 
    }   echo "</td></tr></form>";
    
    }
    echo "</tbody></table></div>";



?>