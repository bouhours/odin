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

/*--------------------------------------------*/
/*!
* Signature Pad v3.0.0-beta.3 | https://github.com/szimek/signature_pad
* (c) 2018 Szymon Nowak | Released under the MIT license
*/



/*
Fonctions
 */

function afficheur(element) {
    if (element.value !== -1) {
        document.getElementById(element.parentElement.dataset.bfmw).classList.remove("hide");
        document.getElementById(element.parentElement.dataset.bfmw).dataset.bfmw6 = element.value;
    } else {
        document.getElementById(element.parentElement.dataset.bfmw).classList.add("hide");
    }
}

/*
INLINE
 */
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("selecteur_affectations");
    for (var i = 0; i < lesElements.length; i++) {
        if (lesElements[i].length == 2) {
            lesElements[i][1].selected = true;
            afficheur(lesElements[i]);
        }
        lesElements[i].onchange = function () {
            afficheur(this);
        }
    }
});