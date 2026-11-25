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
    document.getElementById("id_selecteur_form").onchange = function() {
        document.location.href = "?p=verif&s="+this.dataset.bfmw+"&f="+this.value;
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("do_detail");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function() {
            bfmw_jx("?do_detail=harmonisation",function(reponse){
                showMessage("info","Détail",reponse);
            },function(reponse){
                showMessage("","Détail","Il y a eu une erreur lors de la génération du détail");
            },"POST","et="+this.dataset.bfmw+"&f="+this.dataset.bfmw2+"&a="+this.dataset.bfmw3+"&s="+this.dataset.bfmw4);
            return false;
        };
    }
});
