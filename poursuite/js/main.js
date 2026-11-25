/*
 * Auteur : Cédric BOUHOURS
 * Ce code est mis à disposition selon les termes de la Licence Creative Commons Attribution
 * Pas d'Utilisation Commerciale - Pas de Modification 4.0 International.
 *
 * Attribution — Vous devez créditer l'Œuvre, intégrer un lien vers la licence. Vous devez indiquer ces informations par tous les moyens raisonnables, sans toutefois suggérer que l'Offrant vous soutient ou soutient la façon dont vous avez utilisé son Oeuvre.
 *
 * Pas d’Utilisation Commerciale — Vous n'êtes pas autorisé à faire un usage commercial de cette Oeuvre, tout ou partie du matériel la composant.
 *
 * Pas de modifications — Dans le cas où vous effectuez un remix, que vous transformez, ou créez à partir du matériel composant l'Oeuvre originale, vous n'êtes pas autorisé à distribuer ou mettre à disposition l'Oeuvre modifiée.
 *
 * Pas de restrictions complémentaires — Vous n'êtes pas autorisé à appliquer des conditions légales ou des mesures techniques qui restreindraient légalement autrui à utiliser l'Oeuvre dans les conditions décrites par la licence.
 *
 *
 */

//********************************
//Functions
//********************************
function filter_etudiants(filtre) {
    autoLogOut();
    var lesCheckBox = document.getElementsByClassName('filtrable');
    for (i = 0; i < lesCheckBox.length; i++) {
        if (lesCheckBox[i].dataset.filter === "id_" + filtre) {
            lesCheckBox[i].style.display = "block";
            lesCheckBox[i].required = true;
        } else {
            lesCheckBox[i].style.display = "none";
            lesCheckBox[i].required = false;
        }
    }
}

function showSpecificFicheJury(idEtudiant) {
    autoLogOut();
    var xhttp;
    if (window.XMLHttpRequest) {
        xhttp = new XMLHttpRequest();
    } else {
        xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xhttp.open("POST", "index.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhttp.send("getSpecific="+idEtudiant);
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState === 4 && xhttp.status === 200) {
            showMessage("success", "Détail fiche", xhttp.responseText);
        }
    };
}

//********************************
//Functions
//********************************
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("texte_menu");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            showResponsiveMenu();
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("show_modal_specific_jury");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            showSpecificFicheJury(this.dataset.bfmw);
            return false;
        };
    }
});