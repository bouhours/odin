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
function checkForm(formulaire) {
    autoLogOut();
    var matieres = false;
    if (formulaire['matiere[]'].checked) {
        matieres = true;
    } else {
        for (var i = 0; i < formulaire['matiere[]'].length; i++) {
            if (formulaire['matiere[]'][i].checked) {
                matieres = true;
                break;
            }
        }
    }

    if (!matieres) {
        showMessage("warning", "Attention", "Vous devez sélectionner au moins une matière.");
        return false;
    }

    matieres = true;
    var lesElementsToCheck = document.getElementsByClassName("to_check");
    for (var i = 0; i < lesElementsToCheck.length; i++) {
        matieres &= lesElementsToCheck[i].value.trim().match(/^((0?[1-9]|[1-9][0-9])(((\.|,)[0-9]([0-9])?)?))|(0(\.|,)[0-9]([0-9])?)$/) !== null;
    }

    if (!matieres) {
        showMessage("warning", "Attention", "Les coefficients doivent être compris entre 0.01 et 99.99");
        return false;
    }

    matieres = true;
    lesElementsToCheck = document.getElementsByClassName("to_check_ue");
    for (var i = 0; i < lesElementsToCheck.length; i++) {
        matieres &= lesElementsToCheck[i].value.trim().match(/^((auto)|((0?[1-9]|[1-9][0-9])(((\.|,)[0-9]([0-9])?)?))|(0(\.|,)[0-9]([0-9])?))$/) !== null;
    }

    if (!matieres) {
        showMessage("warning", "Attention", "Les coefficients des UE doivent être compris entre 0.01 et 99.99 ou 'auto' pour le calcul automatique");
        return false;
    }

    return true;
}
/*
INLINE
 */
toDoOnLoad(function () {
    document.getElementById("id_selecteur_groupe").onchange = function () {
        location.href = '?p=bilan&g=' + this.value + '&a=' + this.dataset.bfmw;
    };
});
toDoOnLoad(function () {
    document.getElementById("id_formulaire").onsubmit = function () {
        return checkForm(this);
    };
});
toDoOnLoad(function () {
    document.getElementById("id_selection_annee").onchange = function() {
        document.location.href = "?p=bilan&a="+this.value;
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("select_all");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onchange = function () {
            var aSelectionner;
            var old;
            if (this.checked) {
                aSelectionner = document.querySelectorAll(".unselect_all_"+this.dataset.bfmw);
                for (var j = 0; j < aSelectionner.length; j++) {
                    old = aSelectionner[j].checked;
                    aSelectionner[j].checked = true;
                    if (old !== aSelectionner[j].checked) {
                        aSelectionner[j].onchange();
                    }
                }
            } else {
                aSelectionner = document.querySelectorAll(".unselect_all_"+this.dataset.bfmw);
                for (var j = 0; j < aSelectionner.length; j++) {
                    old = aSelectionner[j].checked;
                    aSelectionner[j].checked = false;
                    if (old !== aSelectionner[j].checked) {
                        aSelectionner[j].onchange();
                    }
                }
                aSelectionner = document.querySelectorAll(".select_all_"+this.dataset.bfmw2);
                for (var j = 0; j < aSelectionner.length; j++) {
                    old = aSelectionner[j].checked;
                    aSelectionner[j].checked = false;
                    if (old !== aSelectionner[j].checked) {
                        //aSelectionner[j].onchange();
                    }
                }
            }
        };
    }
});