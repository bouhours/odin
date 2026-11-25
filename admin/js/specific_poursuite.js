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
    var lesElements = document.getElementsByName("confirm_suppres_pmatiere");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm('Voulez-vous vraiment supprimer cette matière de poursuite d\'étude ?');
        };
    }

    lesElements = document.getElementsByName("confirm_suppres_matiere");
    for (i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm('Voulez-vous vraiment supprimer cette matière ?');
        };
    }

    lesElements = document.getElementsByClassName("confirm_suppres_avis");
    for (i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm('Voulez-vous vraiment supprimer cet avis (cela ne supprimera pas les avis déjà donné) ?');
        };
    }

    lesElements = document.getElementsByClassName("confirm_suppres_categorie");
    for (i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm('Voulez-vous vraiment supprimer cette catégorie (cela ne supprimera pas les avis déjà donné) ?');
        };
    }

    lesElements = document.getElementsByClassName("updater");
    for (i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function (event) {
            autoLogOut();
            showUpdater(event,this.dataset.bfmw,document.getElementById(this.dataset.bfmw2).innerText,this.dataset.bfmw3,this.dataset.bfmw2,"sdlfitbzelrutnchsdlj");
            return false;
        };
    }
});
toDoOnLoad(function () {
    let lesElements = document.getElementsByClassName("bind");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            bind('zerqsfdaedfae(ty', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});
toDoOnLoad(function () {
    let lesElements = document.getElementsByClassName("bind2");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            bind('djsplhgqjzilgcqsdf', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});
toDoOnLoad(function () {
    let lesElements = document.getElementsByClassName("bind3");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onblur = function () {
            if (!(this.value.trim().match(/^(0?[1-9]|[12][0-9]|3[01])[\/](0?[1-9]|1[012])[\/]([2][0][123][0-9]) ([01]\d|2[0-3])h([0-5]\d)$/) !== null || this.value.trim() === "")) {
                showMessage("warning", "Attention", "Le format des périodes de saisie des étudiants n'est pas correct.");
                return false;
            }

            bind('hgdljhhgsfdbhkgvjlyf', this.value, null, this, this, null);
        };
    }
});