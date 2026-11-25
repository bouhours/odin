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
    document.getElementById("id_selecteur_annee").onchange = function() {
        document.location.href = "?p=soutenances&a="+this.value;
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByName("confirm_suppres_creneau");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm('Voulez-vous vraiment supprimer ce créneau et tout ce qui y fait référence ?');
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByName("confirm_suppres_planning");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm('Voulez-vous vraiment supprimer ce planning et tout ce qui y fait référence ?');
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("confirm_del_rdv");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm('Voulez-vous vraiment annuler ce rendez-vous ?');
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onblur = function () {
            bind('seirubgyflqsdjkfnhqlsudyfb', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind2");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            bind('seirubgyflqsdjkfnhqlsudyfb', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("updater");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function (event) {
            autoLogOut();
            showUpdater(event,this.dataset.bfmw,document.getElementById(this.dataset.bfmw2).innerText,this.dataset.bfmw3,this.dataset.bfmw2,"seirubgyflqsdjkfnhqlsudyfb");
            return false;
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("new_creneau");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onsubmit = function () {
            var params = "CRENEAU_DEBUT="+this['CRENEAU_DEBUT'].value+"&CRENEAU_FIN="+this['CRENEAU_FIN'].value+"&PLANNING_ID="+this.dataset.bfmw;
            var id = this.dataset.bfmw;
            bfmw_jx("?submit_creneau_planning=1", function(texte){
                if (texte !== "KO") {
                    var ul = document.getElementById("id_list_creneau_"+id);
                    var li = document.createElement("li");
                    li.classList.add("rien");
                    li.appendChild(document.createTextNode(texte));
                    ul.appendChild(li);
                }
            }, null, "POST", params);
            return false;
        };
    }
});