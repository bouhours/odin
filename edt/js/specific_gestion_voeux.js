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
    document.getElementById("select_periode").onchange = function(){
        window.location.href = '?p=gestion_voeux&periode=' + this.value;
    }
});
toDoOnLoad(function () {
    document.getElementById("select_formation").onchange = function(){
        window.location.href = '?p=gestion_voeux&periode='+this.dataset.bfmw+'&form=' + this.value;
    }
});
/*toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("afficheur_prof");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            var les_profs = document.getElementsByClassName("un_prof");
            for (var j = 0; j < les_profs.length; j++) {
                var un_prof = les_profs[j];
                if (un_prof.dataset.bfmw === this.dataset.bfmw || this.dataset.bfmw === "all") {
                    un_prof.style = "display:block;";
                } else {
                    un_prof.style = "display:none;";
                }
            }
            return false;
        };
    }
});*/
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onblur = function () {
            bind('jxfhchgk(tç-_yer', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind2");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            bind('jxfhchgk(tç-_yer', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind3");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onblur = function () {
            bind('mljhqedpfibaqerpfimibhj', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind4");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            bind('mljhqedpfibaqerpfimibhj', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});