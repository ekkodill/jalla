	<center><legend>Legg til bruker</legend></center><br>
	<div class="leggtilbruker"><br>
		<form action="nybruker.php" method="post" id="nybruker">
			<table>
				<tr>
					<th class="tab1">Epost</th>
					<th class="tab1">Etternavn</th>
					<th class="tab1">Fornavn</th>
					<th class="tab1">Brukertype</th>
				</tr>
				<tr>
					<td><input class="tarea" type="text" name="ePost" id="ePost"></td>
					<td><input class="tarea" type="text" name="etternavn" id="etternavn"></td>
					<td><input class="tarea" type="text" name="fornavn" id="fornavn"></td>
					<td>
						<select  class="tarea" name='btype' id="nytype">
						<option value='velg' selected >Velg brukertype...</option>
					    <option value='administrator' >Administrator</option>
					    <option value='veileder'>Veileder</option>
					    <option value='deltaker'>Deltaker</option>
					    </select>
					</td>	
				</tr>
			</table>
			<h7 class="paakrev">*Må fylles inn.</h7><br>
		<center><input class"leggtilny" type="submit" value="Legg til ny bruker" onclick="return regNy()"></center>
		</form>
    </div>
		<br>
			<br>
			<br>
		<br>