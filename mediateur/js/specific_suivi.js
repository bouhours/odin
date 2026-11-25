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
    document.getElementById("id_saisie_message").onkeypress = function () {
        autoLogOut();
    };
});
toDoOnLoad(function () {
    var d = new Date();
    document.getElementById("id_date_aujourdhui").value = d.getDate() + "/" + (d.getMonth() + 1) + "/" + d.getFullYear();
});
toDoOnLoad(function () {
    document.getElementById("id_selecteur_promo").onchange = function () {
        window.location.href = '?p=suivi&g=' + this.value + '&a=' + this.dataset.bfmw;
    };
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("confirm_suppr_suivi");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm('Voulez-vous vraiment supprimer ce suivi ?');
        };
    }
});
toDoOnLoad(function () {
    document.getElementById("id_selecteur_annee").onchange = function () {
        autoLogOut();
        window.location.href = '?p=suivi&a=' + this.value + '&g=' + this.dataset.bfmw;
    };
});
