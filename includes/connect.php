﻿<?php
//Denne siden er utviklet av Kurt A. Amodt., siste gang endret 02.03.2014
//Denne siden er kontrollert av Erik Bjørnflaten siste gang 26.03.2014 

//Funksjon som returnerer en databasetilkobling
function getDB() {
		$db = new mysqli("158.36.31.5", "touch_db", "touch_pw", "touch2014", "3306");
		//$db = new mysqli("localhost", "erik", "fiskedammen", "utviklingsoppgave");
			if ($db->connect_errno) {
		    die("Kan ikke koble til databasen: Prøv igjen senere");
		}	return $db;
}



?>