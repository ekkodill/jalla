<!--Denne siden er utviklet av Kurt A. Aamodt og Erik Bjørnflaten, siste gang endret 03.03.2014
Denne siden er kontrollert av Kurt A. Aamodt siste gang 03.03.2014  !-->

<?php
include_once 'includes/init.php';

$db = getDB();


//Henter alle brukere og skriver ut i en tabell
$result = mysqli_query($db, "SELECT * FROM brukere");
//$result = $db->query("SELECT * FROM brukere");
    echo "<div class='bliste'><table id='myTable' class='tablesorter'>";
    echo "<thead>
    <tr><th class='tab2'><b>Epost</b></th>
    	<th class='tab2'><b>Etternavn</b></th>
    	<th class='tab2'><b>Fornavn</b></th>
    	<th class='tab2'><b>Brukertype</b></th>
    </tr>
    	</thead><tbody id='liste'>";
//Går gjennom arrayen og lager en form hvor hver rad. På denne måten kan vi slette og redigere brukere via formene.
    while ($row = $result->fetch_assoc()) {
    if($row['brukertype'] == '1') $type = "Admin";
    if($row['brukertype'] == '2') $type = "Veileder";
    if($row['brukertype'] == '3') $type = "Deltaker";
    $PK = $row['brukerPK'];

	echo "<tr>
                <td class='tab2' id='ep".$PK."' name='ePost'>$row[ePost]</td>
                <td class='tab2' id='et".$PK."' name='etternavn'>$row[etternavn]</td>
                <td class='tab2' id='fo".$PK."' name='fornavn'>$row[fornavn]</td>
                <td class='tab2' id='bt".$PK."' name='brukertype'>".$type."</td>";
    echo "<td><form class='redsle'action='/' method='post' id='multiform".$PK."'>
                <input type='image' src='img/edit.jpg' id='R".$PK."' value='Edit' onclick='return rediger(this)'/>
                <input type='hidden'  name='lagredb' value='$row[brukerPK]' />
                <input type='image' src='img/save.jpg' id='lagre".$PK."' onclick='return lagre();' />
                <input type='hidden' name='slett' value='$row[brukerPK]' />
                <input type='image' src='img/delete.jpg' name='formDelete' value='Delete' onclick='return slette(\"$row[fornavn]\", \"$row[etternavn]\", $PK);'  />
            </form>
        </td>
        </tr>";
    }
    echo "</tbody></table></div>";


?>

