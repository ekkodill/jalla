function regNyoppg() {
	if (document.getElementById('oppgtitt').value === "") {
			alert("Tittel må fylles inn");
            return false;
		}
		if (document.getElementById('oppgtext').value === "") {
			alert("Oppgavetekst må fylles inn");
            return false;
		}
		var radiobtn = document.getElementsByName('vansklighetsgrad');
		for(var i = 0; i < radiobtn.length; i++) {
			if(radiobtn[i].type === 'radio' && radiobtn[i].checked) {
				return true;	
			}
		} alert("Du må velge vanskelighetsgrad");
			return false;

      }    