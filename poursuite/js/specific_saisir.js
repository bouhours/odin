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
function lockValeurPerso(){
    var lesElements = document.getElementsByName("PMAT_MODE");
    for (var i = 0; i < lesElements.length; i++) {
        if (lesElements[i].value==="PERSO") {
            document.getElementById("valeur_perso").disabled = !lesElements[i].checked;
        }
    }
}
/*
INLINE
 */
toDoOnLoad(function () {
    window.onbeforeunload = function () {
        var xhttp;
        if (window.XMLHttpRequest) {
            xhttp = new XMLHttpRequest();
        } else {
            xhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xhttp.open("POST", "index.php", false);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("free="+document.getElementById("id_specific_matiere_free").value);
    };
});
toDoOnLoad(function () {
    lockValeurPerso();
    document.getElementById("id_selecteur_matiere").onchange = function () {
        document.location.href = '?p=saisir&g=' + this.dataset.bfmw + '&m=' + this.value
    };
});
toDoOnLoad(function () {
    document.getElementById("selecteur_promo").onchange = function () {
        document.location.href = '?p=saisir&m=' + this.dataset.bfmw + '&g=' + this.value
    };
});
toDoOnLoad(function () {
    document.getElementById("id_niveau_matiere").onchange = function () {
        var textfield = document.getElementById('niveau_matiere');
        textfield.value = this.value;
        bind('sgh7834sdffghgkhj', textfield.value, this.dataset.bfmw, textfield, textfield, null);
    };
});
toDoOnLoad(function () {
    document.getElementById("niveau_matiere").onblur = function () {
        var textfield = document.getElementById('niveau_matiere');
        textfield.value = this.value;
        bind('sgh7834sdffghgkhj', this.value, this.dataset.bfmw, this, this, null);
    };
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByName("name_niveau_eleve");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onchange = function () {
            var textfield = document.getElementById('niveau_eleve_'+this.dataset.bfmw);
            textfield.value = this.value;
            bind('jdljhgwdxfwxsfdgb', textfield.value, this.dataset.bfmw2, textfield, textfield, null);
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onblur = function () {
            bind('jdljhgwdxfwxsfdgb', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind2");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            lockValeurPerso();
            bind('zelsfdjbntyzoeugc', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind3");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onblur = function () {
            bind('zelsfdjbntyzoeugc', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});