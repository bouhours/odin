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

/*
INLINE
 */
toDoOnLoad(function () {
    document.getElementById("id_selection_annee").onchange = function() {
        document.location.href = "?p=groupe&g="+this.dataset.bfmw+"&a="+this.value;
    }
});
toDoOnLoad(function () {
    document.getElementById("id_selection_groupe").onchange = function() {
        document.location.href = "?p=groupe&a="+this.dataset.bfmw+"&g="+this.value;
    }
});

toDoOnLoad(function () {
    let lesElements = document.getElementsByClassName("synchro");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onscroll = function () {
            let leFrere= null;
            if (this.id === "x_"+this.dataset.bfmw) {
                leFrere = document.getElementById("y_" + this.dataset.bfmw);
            } else {
                leFrere = document.getElementById("x_" + this.dataset.bfmw);
            }
            autoLogOut();
            if (leFrere.scrollTop !== this.scrollTop) {
                leFrere.scrollTop = this.scrollTop;
            }
        };
    }
});

function compteur() {
    let identifiant = this.dataset.bfmw;
    let text = this.value.replace(/\s+$/g, "")
    let split = text.split("\n")
    let affichage = split.length > 1 ? split.length + " étudiants" : split.length + " etudiant";

    document.getElementById("nbinscrits_" + identifiant).innerHTML = affichage;
    autoLogOut();
}

toDoOnLoad(function () {
    let lesElements = document.getElementsByClassName("count");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onkeyup = function () {
            compteur.call(this);
        };
    }
});

toDoOnLoad(function () {
    let lesElements = document.getElementsByClassName("count");
    for (let i = 0; i < lesElements.length; i++) {
        compteur.call(lesElements[i]);
    }
});