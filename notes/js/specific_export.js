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

toDoOnLoad(function () {
    document.getElementById("id_selection_annee").onchange = function() {
        if (this.dataset.bfmw != "") {
            document.location.href = "?p=export&f=" + this.dataset.bfmw + "&a=" + this.value;
        } else {
            document.location.href = "?p=export&s=" + this.dataset.bfmw2 + "&a=" + this.value;
        }
    }
});
toDoOnLoad(function () {
    document.getElementById("id_selection_semestre").onchange = function() {
        document.location.href = "?p=export&a="+this.dataset.bfmw+"&s="+this.value;
    }
});
toDoOnLoad(function () {
    document.getElementById("id_selection_formation").onchange = function() {
        document.location.href = "?p=export&a="+this.dataset.bfmw+"&f="+this.value;
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onblur = function () {
            bind('lkutfbydgvosdfyngl',this.value,this.dataset.bfmw,this,this,null);
        };
    }
});
toDoOnLoad(function () {
    document.getElementById("id_submiter").onsubmit = function() {
        me = document.getElementById("id_submiter");
        setTimeout(function () {

            if (me.dataset.bfmw3 == "") {
                document.location.href = "?p=export&a="+me.dataset.bfmw+"&s="+me.dataset.bfmw2;
            } else {
                document.location.href = "?p=export&a="+me.dataset.bfmw+"&f="+me.dataset.bfmw3;
            }

        },2000);

    }
});