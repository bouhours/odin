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
    document.getElementById("id_selecteur_semestre").onchange = function () {
        window.location.href = '?p=mediateur&s=' + this.value + '&g=' + this.dataset.bfmw + '&selon=' + this.dataset.bfmw2;
    };
});
toDoOnLoad(function () {
    document.getElementById("id_selecteur_promo").onchange = function () {
        window.location.href = '?p=mediateur&s='+ this.dataset.bfmw+'&g=' + this.value + '&selon=' + this.dataset.bfmw2;
    };
});
toDoOnLoad(function () {
    document.getElementById("id_selecteur_annee").onchange = function () {
            window.location.href = '?p=mediateur&g='+this.dataset.bfmw+'&e='+this.dataset.bfmw2+'&a=' + this.value;
    };
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("afficheur_controle");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            var elementCourant = this;
            var lesLignes = document.getElementsByClassName("specific_afficher_note_"+elementCourant.dataset.bfmw);
            if (elementCourant.innerHTML === "+") {
                elementCourant.innerHTML = "-";
                elementCourant.title = "Masquer les contrôles";
                for (var j = 0; j < lesLignes.length; j++) {
                    lesLignes[j].style.display = "table-row";
                }
            } else {
                elementCourant.innerHTML = "+";
                elementCourant.title = "Afficher les contrôles";
                for (var j = 0; j < lesLignes.length; j++) {
                    lesLignes[j].style.display = "none";
                }
            }
            return false;
        };
    }
});