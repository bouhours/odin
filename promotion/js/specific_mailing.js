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
function checkForm(leformulaire) {
    autoLogOut();
    if (leformulaire['sujet_mail'].value.trim() === "") {
        showMessage('warning', 'Envoyer un mail', "Attention, le sujet du mail est obligatoire");
        return false;
    }
    if (leformulaire['message'].value.trim() === "") {
        showMessage('warning', 'Envoyer un mail', "Attention, le corps du mail est obligatoire");
        return false;
    }
    return true;
}
/*
INLINE
 */
toDoOnLoad(function () {
    document.getElementById("id_add_piece_jointe").onclick = function () {
        autoLogOut();
        if (document.getElementById("id_add_piece_jointe").checked) {
            document.getElementById("id_div_piece_jointe").style.display = 'inherit';
        } else {
            document.getElementById("id_div_piece_jointe").style.display = 'none';
        }
    };
});
toDoOnLoad(function () {
    document.getElementById("id_form").onsubmit = function () {
        return checkForm(this);
    };
});
toDoOnLoad(function () {
    document.getElementById("id_saisie_message").onkeypress = function () {
        autoLogOut();
    };
});