var arretsLoaded = false;

$("#afficherLignes").on("click", function() {
    if (arretsLoaded)
        return;

	// $("#arrets").load(ajaxArrets.php);
	loadArrets();
    arretsLoaded = true;
});

function loadArrets() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		document.getElementById("arrets").innerHTML = this.responseText;
    } else {
		document.getElementById("arrets").innerHTML = "Chargement des arrêts...";
	}
  };
  xhttp.open("GET", "ajaxArrets.php", true);
  xhttp.send();
}

$("#arrets").on("change", function() {
	loadLignes();
});

function loadLignes() {
	var url = "ajaxLignes.php";

	var selectArret = document.getElementById("selectArret");
	var selectedArret = selectArret.options[selectArret.selectedIndex].value;
	
	var params = "?arret="+selectedArret;
	
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		document.getElementById("lignes").innerHTML = this.responseText;
	} else {
		document.getElementById("lignes").innerHTML = "Chargements des lignes...";
	}	
	};
	xhttp.open("GET", url+params, true);
	xhttp.send();
}

$("#lignes").on("change", function() {
	loadSens();
});

function loadSens() {
	var url = "ajaxSens.php";

	var selectArret = document.getElementById("selectArret");
	var selectedArret = selectArret.options[selectArret.selectedIndex].value;
	
	var selectLigne = document.getElementById("selectLigne");
	var selectedLigne = selectLigne.options[selectLigne.selectedIndex].value;
	
	var params = "?arret="+selectedArret+"&ligne="+selectedLigne;
	
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		document.getElementById("sens").innerHTML = this.responseText;
	} else {
		document.getElementById("sens").innerHTML = "Chargements des sens...";
	}	
	};
	xhttp.open("GET", url+params, true);
	xhttp.send();
}