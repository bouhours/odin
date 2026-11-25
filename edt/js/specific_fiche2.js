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

function doDispo(me) {
    var laCase = me;
    bind('lsjcnhlseufnclsf', me.dataset.bfmw, me.dataset.bfmw2, me, null, function () {
        if (laCase.innerHTML.search("vert") !== -1) {
            laCase.innerHTML = "<span class='rouge'>indisponible</span>";
        } else {
            laCase.innerHTML = "<span class='vert'>disponible</span>";
        }
    });
}

/*
INLINE
 */
toDoOnLoad(function () {
    document.getElementById("id_disponibilites").onselectstart = function() {
        return false;
    };
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("confirm_supprimer");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm("Voulez-vous vraiment supprimer cette matière ?")
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("confirm_supprimer2");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm("Voulez-vous vraiment supprimer cet examen ?")
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("dispo");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function(){
            doDispo(this);
        };
        lesElements[i].onmouseenter = function (e) {
            if (e.buttons == 1) {
                doDispo(this);
            }
        }
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onblur = function () {
            bind('jytkhthdxhjgftzeatyu', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind2");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onchange = function () {
            var courant = this;
            bind('jytkhthdxhjgftzeatyu', this.value, this.dataset.bfmw, this, this, function(){
                window.location.replace("?p=fiche&pe="+courant.dataset.bfmw2)
            });
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind4");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onblur = function () {
            bind('oliuoiusfegsdfg', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind3");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onchange = function () {
            bind('oliuoiusfegsdfg', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});