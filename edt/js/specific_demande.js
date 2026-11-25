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

/*
Fonctions
 */
function lazyLoad(dest) {
    autoLogOut();
    var xhttp;
    if (window.XMLHttpRequest) {
        xhttp = new XMLHttpRequest();
    } else {
        xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xhttp.open("POST", "index.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhttp.send("bind=doing&edt=modification");
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState === 4 && xhttp.status === 200) {
            dest.innerHTML =  xhttp.responseText;
        }
    };
}
/*
INLINE
 */
toDoOnLoad(function () {
    document.getElementById("dest_lazyLoad").style.display = "none";
    document.getElementById("nouveau").style.display = "none";
    document.getElementById("modification").style.display = "none";
    document.getElementById("suppression").style.display = "none";
});
toDoOnLoad(function () {
    document.getElementById("nouveau_creneau").onclick = function(){
        document.getElementById("les_boutons").style.display = "none";
        document.getElementById("nouveau").style.display = "block";
        return false;
    }
});
toDoOnLoad(function () {
    document.getElementById("modification_creneau").onclick = function(){
        document.getElementById("les_boutons").style.display = "none";
        document.getElementById("modification").style.display = "block";
        document.getElementById("dest_lazyLoad").style.display = "block";
        lazyLoad(document.getElementById("dest_lazyLoad"));
        return false;
    }
});
toDoOnLoad(function () {
    document.getElementById("suppression_creneau").onclick = function(){
        document.getElementById("les_boutons").style.display = "none";
        document.getElementById("suppression").style.display = "block";
        document.getElementById("dest_lazyLoad").style.display = "block";
        lazyLoad(document.getElementById("dest_lazyLoad"));
        return false;
    }
});
toDoOnLoad(function () {
    document.getElementById("submit_nouveau").onclick = function(){
        if (document.getElementById("commentaire").value.trim() === "") {
            autoLogOut();
            showMessage("warning", "Attention", "Veuillez indiquer dans le champ de saisie les informations permettant de créer le créneau.");
            return false;
        }
        return true;
    }
});
toDoOnLoad(function () {
    document.getElementById("submit_modification").onclick = function(){
        autoLogOut();
        var lesCreneaux = document.getElementsByName("creneau[]");
        for (var i = 0; i < lesCreneaux.length; i++) {
            if (lesCreneaux[i].checked) {
                return true;
            }
        }
        showMessage("warning", "Attention", "Veuillez cocher le ou les créneaux que vous souhaitez modifier.");
        return false;
    }
});
toDoOnLoad(function () {
    document.getElementById("submit_suppression").onclick = function(){
        autoLogOut();
        var lesCreneaux = document.getElementsByName("creneau[]");
        for (var i = 0; i < lesCreneaux.length; i++) {
            if (lesCreneaux[i].checked) {
                return true;
            }
        }
        showMessage("warning", "Attention", "Veuillez cocher le ou les créneaux que vous souhaitez annuler.");
        return false;
    }
});