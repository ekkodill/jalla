//Denne siden er utviklet av Mikael Kolstad, siste gang endret 03.03.2014
//Denne siden er kontrollert av Kurt A. Amodt siste gang 03.03.2014 !-->

function passwordCheck() {
		      
if (document.reg.password.value != document.reg.passwordcheck.value) {
    alert('Passordene må være like!');
	document.reg.password.focus();
    return false;
}
else if (document.reg.password.value.length < 8 || document.reg.passwordcheck.value.length < 8) {
	alert('Passordet må være 8 tegn eller mer')
	return false;
}

else {
	alert("Passordet ble endret");
    document.reg.submit();
    return true; 
}
}








	

	
	
